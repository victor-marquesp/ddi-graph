<?php

use App\Models\Classification;
use App\Models\User;
use App\Models\Drug;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('index', function () {
    
    it('shows classifications', function () {

        $this->get(route('classifications.index'))->assertOk();
    });

});

describe('show', function () {

    it('shows a classification', function () {

        $classification = Classification::factory()->create();

        $this->get(route('classifications.show', $classification))->assertOk();
    });

});

describe('create', function () {

    it('shows the create form when authenticated', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('classifications.create'))->assertOk();
    });

    it('does not shows the create form to guests', function () {

        $this->get(route('classifications.create'))->assertRedirect(route('auth.required'));

    });

});

describe('store', function () {

    it('stores a a classification with valid data', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Analgesic',
            'description' => 'Relieves pain'
        ];

        $this->post(route('classifications.store'), $data)->assertRedirect();

        $this->assertDatabaseHas('classifications', ['name' => 'Analgesic']);
    });

    it('does not store a classification with invalid data', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => null,
            'description' => 'sad path test'
        ];

        $this->post(route('classifications.store'), $data)
            ->assertSessionHasErrors([
                'name'
            ]);

        $this->assertDatabaseMissing('classifications', ['description' => 'sad path test']);
    });

    it('does not store a classification when the requester is a guest', function () {

        $data = [
            'name' => 'Analgesic',
            'description' => 'sad path test'
        ];

        $this->post(route('classifications.store'), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseMissing('classifications', ['name' => 'Analgesic']);
    });

    it('does not store a duplicated name', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        Classification::factory()->create(['name' => 'Analgesic']);

        $data = [
            'name' => 'Analgesic'
        ];

        $this->post(route('classifications.store'), $data)
            ->assertSessionHasErrors([
                'name'
        ]);

    });

});

describe('edit', function () {

    it('shows the edit form to authenticated users', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $classification = Classification::factory()->create();

        $this->get(route('classifications.edit', $classification))->assertOk();
    });

    it('does not show the edit form to guests', function () {

        $classification = Classification::factory()->create();

        $this->get(route('classifications.edit', $classification))->assertRedirect(route('auth.required'));

    });
    
});

describe('update', function () {
    
    it('updates a classification with valid data', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $classification = Classification::factory()->create([
            'name' => 'Analgesic',
            'description' => null
        ]);

        $this->put(route('classifications.update', $classification), [
            'name' => 'Antidepressant',
            'description' => 'Treat mood and mental health disorders'
            ])->assertRedirect();
        
        $this->assertDatabaseHas('classifications', [
            'name' => 'Antidepressant', 
            'description' => 'Treat mood and mental health disorders'
        ]);
    });

    it('does not update a classification with invalid data', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $classification = Classification::factory()->create([
            'name' => 'Analgesic',
            'description' => null
        ]);

        $this->put(route('classifications.update', $classification), [
            'name' => null,
            'description' => 'Treat mood and mental health disorders'
        ])->assertRedirect();
        
        $this->assertDatabaseHas('classifications', [
            'name' => 'Analgesic',
            'description' => null
        ]);
    });

    it('does not update a classification when the requester is a guest', function () {

        $classification = Classification::factory()->create([
            'name' => 'Analgesic',
            'description' => null
        ]);

        $this->put(route('classifications.update', $classification), [
            'name' => 'Antidepressant',
            'description' => 'Treat mood and mental health disorders'
        ])->assertRedirect(route('auth.required'));
        
        $this->assertDatabaseHas('classifications', [
            'name' => 'Analgesic',
            'description' => null
        ]);
    });

    it('does not update with a duplicated name', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        Classification::factory()->create(['name' => 'Analgesic']);
        $classification = Classification::factory()->create(['name' => 'Antidepressant']);

        $data = [
            'name' => 'Analgesic'
        ];

        $this->put(route('classifications.update', $classification), $data)
            ->assertSessionHasErrors([
                'name'
        ]);

        $this->assertDatabaseHas('classifications', ['name' => 'Antidepressant']);
    });

});

describe('delete', function () {

    it('deletes a classification', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $classification = Classification::factory()->create(['name' => 'Analgesic']);

        $this->delete(route('classifications.destroy', $classification))->assertRedirect();

        $this->assertDatabaseMissing('classifications', ['id' => $classification->id]);
    });

    it('does not delete a classification when the requester is a guest', function () {

        $classification = Classification::factory()->create(['name' => 'Analgesic']);

        $this->delete(route('classifications.destroy', $classification))->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('classifications', ['id' => $classification->id]);
    });
    
    it('does not delete a classification when it has drugs associated', function () {

        $classification = Classification::factory()->create();
        Drug::factory()->create(['classification_id' => $classification->id]);

        $this->delete(route('classifications.destroy', $classification))->assertRedirect();

        $this->assertDatabaseHas('classifications', ['id' => $classification->id]);
    });
});
