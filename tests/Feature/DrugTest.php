<?php

use App\Models\Classification;
use App\Models\User;
use App\Models\Drug;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('index', function () {

    it('shows all drugs', function () {
        $this->get(route('drugs.index'))->assertOk();
    });

});

describe('show', function () {

    it('shows a drug', function () {
        
        $drug = Drug::factory()->create();

        $this->get(route('drugs.show', $drug))->assertOk();
    });

});

describe('create', function () {

    it('shows the create form when authenticated', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('drugs.create'))->assertOk();
    });

    it('does not show the create form when guest', function () {
        $this->get(route('drugs.create'))->assertRedirect(route('auth.required'));
    });

});

describe('store', function () {

    it('stores a drug with valid data', function () {
        $user = User::factory()->create();
        $this->actingAs($user);
        $classification = Classification::factory()->create();

        $data = [
            'name' => 'Paracetamol',
            'description' => 'test description',
            'classification_id' => $classification->id,
        ];

        $this->post(route('drugs.store'), $data)->assertRedirect();

        $this->assertDatabaseHas('drugs', $data);
    });

    it('does not store a drug with invalid data', function () {
        $user = User::factory()->create();
        $this->actingAs($user);
        Classification::factory()->create();

        $data = [
            'name' => null,
            'description' => 'sad path test',
            'classification_id' => 5,
        ];

        $this->post(route('drugs.store'), $data)->assertSessionHasErrors([
            'name',
            'classification_id'
        ]);

        $this->assertDatabaseMissing('drugs', ['description' => 'sad path test']);
    });

    it('does not store a drug without a classification', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Paracetamol',
            'description' => 'sad path test'
        ];

        $this->post(route('drugs.store'), $data)->assertSessionHasErrors([
            'classification_id'
        ]);

        $this->assertDatabaseMissing('drugs', ['name' => 'Paracetamol', 'description' => 'sad path test']);
    });

    it('does not store a drug when the requester is a guest', function () {
        $classification = Classification::factory()->create();

        $data = [
            'name' => 'Paracetamol',
            'description' => 'sad path test',
            'classification_id' => $classification->id,
        ];

        $this->post(route('drugs.store'), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseMissing('drugs', ['name' => 'Paracetamol', 'description' => 'sad path test']);
    });

});

describe('edit', function () {

    it('shows the edit form when authenticated', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $drug = Drug::factory()->create();

        $this->get(route('drugs.edit', $drug))->assertOk();
    }); 

    it('does not show the edit form when guest', function () {

        $drug = Drug::factory()->create();

        $this->get(route('drugs.edit', $drug))->assertRedirect(route('auth.required'));
    });

});

describe('update', function () {

    it('updates a drug with valid data', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $classifications = Classification::factory(2)->create();
        $drug = Drug::factory()->create([
            'name' => 'Paracetamol',
            'classification_id' => $classifications[0]->id
        ]);

        $data = [
            'name' => 'Ibuprofen',
            'description' => 'test update',
            'classification_id' => $classifications[1]->id
        ];

        $this->put(route('drugs.update', $drug), $data)->assertRedirect();

        $this->assertDatabaseHas('drugs', $data);
    });

    it('does not update a drug with invalid data', function() {
    $user = User::factory()->create();
        $this->actingAs($user);

        $classification = Classification::factory()->create();
        $drug = Drug::factory()->create([
            'name' => 'Paracetamol',
            'classification_id' => $classification->id
        ]);

        $data = [
            'name' => null,
            'description' => 'sad test path',
            'classification_id' => 5
        ];

        $this->put(route('drugs.update', $drug), $data)
            ->assertSessionHasErrors([
                'name',
                'classification_id'
            ]);

        $this->assertDatabaseHas('drugs', [
            'id' => $drug->id,
            'name' => 'Paracetamol',
            'description' => $drug->description,
            'classification_id' => $drug->classification_id,
        ]);
    });

    it('does not update a drug when the requester is a guest', function () {

        $classifications = Classification::factory(2)->create();
        $drug = Drug::factory()->create([
            'name' => 'Paracetamol',
            'classification_id' => $classifications[0]->id
        ]);

        $data = [
            'name' => 'Ibuprofen',
            'description' => 'test update',
            'classification_id' => $classifications[1]->id
        ];

        $this->put(route('drugs.update', $drug), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('drugs', [
            'id' => $drug->id,
            'name' => 'Paracetamol',
            'description' => $drug->description,
            'classification_id' => $drug->classification_id,
        ]);
    });

});

describe('delete', function () {

    it('deletes a drug', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $drug = Drug::factory()->create([
            'name' => 'Paracetamol'
        ]);

        $this->delete(route('drugs.delete', $drug))->assertRedirect();

        $this->assertDatabaseMissing('drugs', ['id' => $drug->id]);
    });

    it('does not delete a drug when the requester is a guest', function () {

        $drug = Drug::factory()->create([
            'name' => 'Paracetamol'
        ]);

        $this->delete(route('drugs.delete', $drug))->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('drugs', ['id' => $drug->id]);
    });

});