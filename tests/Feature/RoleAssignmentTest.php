<?php

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

// Make sure cache is cleared before running tests
beforeEach(function() {
    Artisan::call('cache:clear');
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