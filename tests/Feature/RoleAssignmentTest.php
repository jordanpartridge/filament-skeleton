<?php

use App\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

// Make sure cache is cleared and DB is set up for tests
beforeEach(function () {
    Artisan::call('cache:clear');

    // For SQLite in-memory testing, make sure team_id is nullable
    if (config('database.default') === 'sqlite') {
        Config::set('permission.teams', false);
    }
});

// Test permissions can be assigned to roles
it('can assign permissions to roles', function () {
    // Create a permission
    $permission = Permission::create(['name' => 'edit posts']);

    // Create a role without the permission
    $role = Role::create(['name' => 'content manager']);

    // Give the role the permission
    $role->givePermissionTo('edit posts');

    // Verify role has the permission
    expect($role->hasPermissionTo('edit posts'))->toBeTrue();
});

// Test revoking permissions works
it('can revoke permissions from a role', function () {
    // Create a permission
    $permission = Permission::create(['name' => 'edit posts']);

    // Create a role with the permission
    $role = Role::create(['name' => 'content manager']);
    $role->givePermissionTo('edit posts');

    // Verify role has the permission
    expect($role->hasPermissionTo('edit posts'))->toBeTrue();

    // Revoke the permission
    $role->revokePermissionTo('edit posts');

    // Verify permission was revoked
    expect($role->hasPermissionTo('edit posts'))->toBeFalse();
});
