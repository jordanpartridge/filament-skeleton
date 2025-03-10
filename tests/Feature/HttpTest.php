<?php

use App\Models\User;
use App\Models\Role;
use Database\Seeders\PermissionSeeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Make sure cache is cleared and permissions are reset before each test
beforeEach(function () {
    // Disable teams entirely for testing
    Config::set('permission.teams', false);
    $this->seed(PermissionSeeder::class);
    
    // Clear the permission cache
    Artisan::call('cache:clear');
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    
    // Create essential permissions for tests
    createTestPermissions();
});

/**
 * Helper function to create required permissions for tests
 */
function createTestPermissions() {
    // Create permissions if they don't exist
    if (!Permission::where('name', 'admin_access')->exists()) {
        Permission::create(['name' => 'admin_access']);
    }
    
    if (!Permission::where('name', 'view user')->exists()) {
        Permission::create(['name' => 'view user']);
    }
    
    if (!Permission::where('name', 'update user')->exists()) {
        Permission::create(['name' => 'update user']);
    }
    
    // Add the view pulse permission that is required by PulseDashboard
    if (!Permission::where('name', 'view pulse')->exists()) {
        Permission::create(['name' => 'view pulse']);
    }
    
    // Create admin role with permissions if it doesn't exist
    if (!Role::where('name', 'admin')->exists()) {
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['admin_access', 'view user', 'update user', 'view pulse']);
    }
}

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

it('can visit dashboard with proper permissions', function () {
    // Create and setup user with permissions
    $user = User::factory()->create();
    $role = Role::where('name', 'admin')->first();
    
    // Give the role to the user
    $user->assignRole($role);
    
    // Act as the user and test dashboard access
    $this->actingAs($user);
    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('can visit edit user with proper permissions', function () {
    // Create and setup user with permissions
    $user = User::factory()->create();
    $role = Role::where('name', 'admin')->first();
    
    // Give the role to the user
    $user->assignRole($role);
    
    // Act as the user and test edit access
    $this->actingAs($user);
    $response = $this->get('/admin/users/'.$user->id.'/edit');
    $response->assertStatus(200);
});

it('can view user activity if route exists', function () {
    // Check if the activities route exists
    $routes = Route::getRoutes();
    $hasActivityRoute = false;
    
    foreach ($routes as $route) {
        if (strpos($route->uri, 'admin/users/{user}/activities') !== false) {
            $hasActivityRoute = true;
            break;
        }
    }
    
    if (!$hasActivityRoute) {
        $this->markTestSkipped('Activities route does not exist');
        return;
    }
    
    // Create and setup user with permissions
    $user = User::factory()->create();
    $role = Role::where('name', 'admin')->first();
    
    // Give the role to the user
    $user->assignRole($role);
    
    // Act as the user and test activity view access
    $this->actingAs($user);
    $response = $this->get('/admin/users/'.$user->id.'/activities');
    $response->assertStatus(200);
});
