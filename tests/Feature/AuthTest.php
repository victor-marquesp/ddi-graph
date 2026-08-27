<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

describe('login', function () {

    it('shows the login page', function() {

        $response = $this->get(route('auth.login.form'));

        $response->assertOk();
    });

    it('authenticates a user with valid credentials', function () {

        $user = User::factory()->create(['password' => 'pest12345']);

        $response = $this->post(
            route('auth.login'), 
            ['email' => $user->email, 'password' => 'pest12345']
        );

        $response->assertRedirect();

        $this->assertAuthenticatedAs($user);
    });

    it('rejects an inexistent user', function () {

        $this->post(
            route('auth.login'),
            ['email' => 'non.existent@email.com', 'password' => 'pest12345']
        )->assertRedirect();

        $this->assertGuest();
    });

    it('rejects invalid credentials', function () {

        $user = User::factory()->create(['password' => 'pest12345']);

        $this->post(
            route('auth.login'),
            ['email' => $user->email, 'password' => 'PHPUnit12345']
        );

        $this->assertGuest();

    });

    it('requires an email', function() {

        $response = $this->post(
            route('auth.login'),
            ['password' => 'pest12345']
        );

        $response->assertSessionHasErrors('email');
    });

    it('requires a password', function() {

        $response = $this->post(
            route('auth.login'),
            ['email' => 'pest@email.com']
        );

        $response->assertSessionHasErrors('password');
    });

    it('remembers the authenticated user', function () {

        $user = User::factory()->create([
            'password' => 'pest12345'
        ]);

        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'pest12345',
            'remember' => true
        ]);

        $response->assertCookie(Auth::getRecallerName());

        $this->assertAuthenticatedAs($user);
    });

    it('does not remember the authenticated user when remember is false', function () {

        $user = User::factory()->create([
            'password' => 'pest12345'
        ]);

        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'pest12345',
            'remember' => false
        ]);

        $response->assertCookieMissing(Auth::getRecallerName());

        $this->assertAuthenticatedAs($user);
    });

}); 

describe('logout', function () {

    it('logs out an authenticated user', function () {

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('auth.logout'));

        $this->assertGuest();
    });

    it("does not allow a guest to logout", function() {
        
        $this->post(route('auth.logout'))->assertRedirect(route('auth.required'));

        $this->assertGuest();

    });

});
