<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Enums\Severity;
use App\Models\Drug;
use App\Models\Interaction;
use App\Models\User;

uses(RefreshDatabase::class);

describe('index', function () {

    it('shows interactions', function () {
        $this->get(route('interactions.index'))->assertOk();
    });

});

describe('show', function () {

    it('shows an interaction', function () {

        $interaction = Interaction::factory()->create();

        $this->get(route('interactions.show', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]))->assertOk();
    });

});

describe('create', function () {

    it('shows the create form when authenticated', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('interactions.create'))->assertOk();

    });

    it('does not show the create form to guests', function () {
        $this->get(route('interactions.create'))->assertRedirect(route('auth.required'));
    });

});

describe('store', function() {

    it('stores a valid interaction', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug_a = Drug::factory()->create();
        $drug_b = Drug::factory()->create();

        $data = [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => Severity::MODERATE->value,
            'description' => 'test description'
        ];

        $this->post(route('interactions.store'), $data)->assertRedirect();

        $this->assertDatabaseHas('interactions', $data);
    });

    it('does not store an interaction with an invalid severity', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug_a = Drug::factory()->create();
        $drug_b = Drug::factory()->create();

        $data = [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => 'not a severity',
        ];

        $this->post(route('interactions.store'), $data)
            ->assertSessionHasErrors([
                'severity'
            ]);

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => 'not a severity',
        ]);
    });

    it('does not store duplicate interactions regardless of drug order', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug_a = Drug::factory()->create();
        $drug_b = Drug::factory()->create();

        Interaction::factory()->create([
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id
        ]);

        $data = [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => Severity::MODERATE->value,
        ];

        $this->post(route('interactions.store'), $data)
            ->assertRedirect();

        $data = [
            'drugA_id' => $drug_b->id,          // Não duplica com a ordem inversa
            'drugB_id' => $drug_a->id,
            'severity' => Severity::MODERATE->value,
        ];

        $this->post(route('interactions.store'), $data)
            ->assertRedirect();

        $this->assertDatabaseCount('interactions', 1);

    });

    it('does not store an interaction with the same drug', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug = Drug::factory()->create();

        $data = [
            'drugA_id' => $drug->id,
            'drugB_id' => $drug->id,
            'severity' => Severity::MODERATE->value
        ];

        $this->post(route('interactions.store'), $data)->assertRedirect();

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $drug->id,
            'drugB_id' => $drug->id
        ]);
    });

    it('does not store an interaction with an inexistent drug', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug = Drug::factory()->create();

        $data = [
            'drugA_id' => $drug->id,
            'drugB_id' => 999999,
            'severity' => Severity::MODERATE->value
        ];

        $this->post(route('interactions.store'), $data)
            ->assertSessionHasErrors([
                'drugB_id'
            ]);

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $drug->id,
            'drugB_id' => 999999
        ]);
    });

    it('does not store an interaction when the requester is a guest', function () {

        $drug_a = Drug::factory()->create();
        $drug_b = Drug::factory()->create();

        $data = [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => Severity::MODERATE->value,
            'description' => 'test description'
        ];

        $this->post(route('interactions.store'), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id
        ]);
    });

});

describe('edit', function () {

    it('shows the edit form when authenticated', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $interaction = Interaction::factory()->create();

        $this->get(route('interactions.edit', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]))->assertOk();
    });

    it('does not show the edit form to guests', function () {

        $interaction = Interaction::factory()->create();

        $this->get(route('interactions.edit', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]))->assertRedirect(route('auth.required'));
    });

});

describe('update', function () {

    it('updates an interaction', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug_a = Drug::factory()->create();
        $drug_b = Drug::factory()->create();

        $interaction = Interaction::factory()->create([
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => Severity::MODERATE->value,
            'description' => 'test description'
        ]);

        $data = [
            'severity' => Severity::MAJOR->value, 
            'description' => 'test update'
        ];

        $this->put(route('interactions.update', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('interactions', [
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id,
            'severity' => Severity::MAJOR->value,
            'description' => 'test update'
        ]);

    });

    it('does not update an interaction with an invalid severity', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $interaction = Interaction::factory()->create([
            'severity' => Severity::MODERATE->value
        ]);

        $data = [
            'severity' => 'not a severity',
            'description' => 'sad test path'
        ];

        $this->put(route('interactions.update', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]), $data)
            ->assertSessionHasErrors([
                'severity'
            ]);

        $this->assertDatabaseHas('interactions', [
            'drugA_id' => $interaction->drugA_id,
            'drugB_id' => $interaction->drugB_id,
            'severity' => $interaction->severity,
            'description' => $interaction->description
        ]);

    });

    it('does not update an interaction when the requester is a guest', function () {

        $interaction = Interaction::factory()->create([
            'severity' => Severity::MODERATE->value,
            'description' => 'test description'
        ]);

        $data = [
            'severity' => Severity::CONTRAINDICATED->value,
            'description' => 'test update'
        ];

        $this->put(route('interactions.update', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('interactions', [
            'drugA_id' => $interaction->drugA_id,
            'drugB_id' => $interaction->drugB_id,
            'severity' => $interaction->severity,
            'description' => $interaction->description
        ]);

    });

});

describe('delete', function () {

    it('deletes an interaction', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $interaction = Interaction::factory()->create();

        $this->delete(route('interactions.destroy', [
           'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]))->assertRedirect();

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $interaction->drugA_id,
            'drugB_id' => $interaction->drugB_id
        ]);

    });

    it('does not delete an interaction when guest', function () {

        $interaction = Interaction::factory()->create();

        $this->delete(route('interactions.destroy', [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id
        ]))->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('interactions', [
            'drugA_id' => $interaction->drugA_id,
            'drugB_id' => $interaction->drugB_id
        ]);

    });

    it('deletes all interactions related to a Drug when the Drug is deleted', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $drug_a = Drug::factory()->create(['id' => 1]);
        $drug_b = Drug::factory()->create(['id' => 2]);
        $drug_c = Drug::factory()->create(['id' => 3]);

        Interaction::factory()->create([
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_b->id
        ]);

        Interaction::factory()->create([
            'drugA_id' => $drug_a->id,
            'drugB_id' => $drug_c->id
        ]);

        $this->delete(route('drugs.destroy', $drug_a))->assertRedirect();

        $this->assertDatabaseMissing('interactions', [
            'drugA_id' => $drug_a->id
        ]);

        $this->assertDatabaseMissing('interactions', [
            'drugB_id' => $drug_a->id
        ]);

    });

});
