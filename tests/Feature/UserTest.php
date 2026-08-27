<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('index', function () {

    it('shows users to authenticated users', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('users.index'))->assertOk();
    });

    it('does not show users to guests', function () {

        $this->get(route('users.index'))->assertRedirect(route('auth.required'));
    });

});

describe('create', function () {

    it('shows the create form to authenticated users', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('users.create'))->assertOk();
    });

    it('does not show the create form to guests', function () {

        $this->get(route('users.create'))->assertRedirect(route('auth.required'));
    });

});

describe('store', function () {

    it('stores a user with valid data', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'pest',
            'email' => 'pest@email.com',
            'password' => 'pest12345',
            'password_confirmation' => 'pest12345'
        ];

        $this->post(route('users.store'), $data)->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'pest',
            'email' => 'pest@email.com',
        ]);
    });

    it('does not store invalid data', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 12345,
            'email' => 'invalid format',
            'password' => '1',
            'password_confirmation' => '1'
        ];

        $this->post(route('users.store'), $data)
            ->assertSessionHasErrors([
                'name',
                'email',
                'password',
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'invalid format',
        ]);
    });

    it('does not store a user when the requester is a guest', function () {

        $data = [
            'name' => 'pest',
            'email' => 'pest@email.com',
            'password' => 'pest12345',
            'password_confirmation' => 'pest12345'
        ];

        $this->post(route('users.store'), $data)->assertRedirect(route('auth.required'));

        $this->assertDatabaseMissing('users', [
            'email' => 'pest@email.com',
        ]);
    });

});

describe('show', function () {

    it('shows a user to authenticated users', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('users.show', $user))->assertOk();
    });

    it('does not show a user to guests', function () {

        $user = User::factory()->create();

        $this->get(route('users.show', $user))->assertRedirect(route('auth.required'));
    });

});

describe('edit', function () {

    it('shows the edit form to authenticated users', function () {

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('users.edit', $user))->assertOk();
    });

    it('does not show the edit form to guests', function () {

        $user = User::factory()->create();

        $this->get(route('users.edit', $user))->assertRedirect(route('auth.required'));
    });

});

describe('update', function () {

    it('updates a user with valid data', function () {

        $user = User::factory()->create([
            'name' => 'original',
            'email' => 'original@email.com',
            'password' => 'original12345',
        ]);

        $this->actingAs($user);

        $this->put(route('users.update', $user), [
            'name' => 'edited',
            'email' => 'edited@email.com',
            'password' => 'edited12345',
            'password_confirmation' => 'edited12345'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'edited',
            'email' => 'edited@email.com',
        ]);
        
    });

    it('does not update a user with invalid data', function () {

        $user = User::factory()->create([
            'name' => 'original',
            'email' => 'original@email.com',
            'password' => 'original12345',
        ]);

        $this->actingAs($user);

        $this->put(route('users.update', $user), [
            'name' => null,
            'email' => 'invalid format',
            'password' => '1',
            'password_confirmation' => '1'
        ])->assertSessionHasErrors([
            'name',
            'email',
            'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'original',
            'email' => 'original@email.com',
        ]);

    });

    it('does not update a user when the requester is a guest', function () {

        $user = User::factory()->create([
            'name' => 'original',
            'email' => 'original@email.com',
            'password' => 'original12345',
        ]);

        $this->put(route('users.update', $user), [
            'name' => 'edited',
            'email' => 'edited@email.com',
            'password' => 'edited12345',
            'password_confirmation' => 'edited12345'
        ])->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'original',
            'email' => 'original@email.com',
        ]);

    });

});

describe('destroy', function () {

    it('deletes a user when authenticated', function () {

        $users = User::factory(10)->create();

        $user = User::factory()->create();

        $this->actingAs($users[1]);

        $this->delete(route('users.destroy', $user))->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    });

    it('logs out the user after deleting their own account', function () {

        User::factory(10)->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->delete(route('users.destroy', $user))->assertRedirect();
        $this->assertGuest();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    });

    it('does not delete a user when the requester is a guest', function () {

        User::factory(10)->create();

        $user = User::factory()->create();

        $this->delete(route('users.destroy', $user))->assertRedirect(route('auth.required'));

        $this->assertDatabaseHas('users', ['id' => $user->id]);

    });

    it('does not delete the only user', function () {
        
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->delete(route('users.destroy', $user))->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $user->id]);

    });

});
