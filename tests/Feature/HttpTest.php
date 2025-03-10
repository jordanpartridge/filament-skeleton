<?php

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Database\Seeders\PermissionSeeder;

beforeEach(function () {
    // For SQLite in-memory testing, make sure team_id is nullable
    if (config('database.default') === 'sqlite') {
        Config::set('permission.teams', false);
    }
    
    // Run the permission seeder
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

it('can visit dashboard with proper permissions', function () {
    // Create a user
    $user = User::factory()->create();
    
    // Create admin access permission
    $permission = Permission::create(['name' => 'admin_access']);
    
    // Create an admin role with the permission
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo('admin_access');
    
    // Assign the role to the user directly in the database
    DB::table('model_has_roles')->insert([
        'role_id' => $role->id,
        'model_id' => $user->id,
        'model_type' => User::class,
        'team_id' => 1  // Provide a default team ID for testing
    ]);
    
    // Act as the user and test dashboard access
    $this->actingAs($user);
    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('can visit edit user with proper permissions', function () {
    // Create a user
    $user = User::factory()->create();
    
    // Create necessary permissions
    $permission = Permission::create(['name' => 'admin_access']);
    $editPermission = Permission::create(['name' => 'update user']);
    
    // Create an admin role with permissions
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo(['admin_access', 'update user']);
    
    // Assign the role to the user directly in the database
    DB::table('model_has_roles')->insert([
        'role_id' => $role->id,
        'model_id' => $user->id,
        'model_type' => User::class,
        'team_id' => 1  // Provide a default team ID for testing
    ]);
    
    // Act as the user and test edit access
    $this->actingAs($user);
    $response = $this->get('/admin/users/'.$user->id.'/edit');
    $response->assertStatus(200);
});

it('can view user activity with proper permissions', function () {
    // Create a user
    $user = User::factory()->create();
    
    // Create necessary permissions
    $permission = Permission::create(['name' => 'admin_access']);
    $viewPermission = Permission::create(['name' => 'view user']);
    
    // Create an admin role with permissions
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo(['admin_access', 'view user']);
    
    // Assign the role to the user directly in the database
    DB::table('model_has_roles')->insert([
        'role_id' => $role->id,
        'model_id' => $user->id,
        'model_type' => User::class,
        'team_id' => 1  // Provide a default team ID for testing
    ]);
    
    // Act as the user and test activity view access
    $this->actingAs($user);
    $response = $this->get('/admin/users/'.$user->id.'/activities');
    $response->assertStatus(200);
});
