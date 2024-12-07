<?php

use App\Models\User;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
});
it('can visit root', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('unauthorized gets redirected to login', function () {
    $response = $this->get('/admin');
    $response->assertRedirect('/admin/login');
});

it('can visit admin', function () {
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
});

it('can visit dashboard', function () {
    $this->actingAs(User::factory()->create());
    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('can visit edit user', function () {
    $this->actingAs($user = User::factory()->create());
    $response = $this->get('/admin/users/'.$user->id.'/edit');
    $response->assertStatus(200);
});

it('can view user activity', function () {
    $this->actingAs($user = User::factory()->create());
    $response = $this->get('/admin/users/'.$user->id.'/activities');
    $response->assertStatus(200);
});
