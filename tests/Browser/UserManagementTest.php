<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Setup the test and create an admin user.
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Create admin role with permissions
        $adminRole = Role::create(['name' => 'admin']);
        
        // Create some permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        $adminRole->givePermissionTo($permissions);
        
        // Create a user with admin role
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $user->assignRole('admin', null);
        
        // Create a few regular users
        User::factory()->count(5)->create();
    }
    
    /**
     * Test that admin can view user list.
     */
    public function test_admin_can_view_user_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    ->clickLink('Users')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->assertSee('Users')
                    ->assertSee('Create user');
        });
    }
    
    /**
     * Test that admin can create a new user.
     */
    public function test_admin_can_create_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    ->clickLink('Users')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->clickLink('Create user')
                    ->waitForRoute('filament.admin.resources.users.create')
                    ->type('name', 'Test User')
                    ->type('email', 'newuser@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Create')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->assertSee('Test User')
                    ->assertSee('newuser@example.com');
        });
    }
    
    /**
     * Test that admin can edit an existing user.
     */
    public function test_admin_can_edit_user()
    {
        $testUser = User::factory()->create([
            'name' => 'User to Edit',
            'email' => 'edit@example.com',
        ]);
        
        $this->browse(function (Browser $browser) use ($testUser) {
            $browser->visit('/admin/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    ->clickLink('Users')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->assertSee('User to Edit')
                    ->clickLink('User to Edit')
                    ->waitForRoute('filament.admin.resources.users.edit', ['record' => $testUser->id])
                    ->type('name', 'Updated User Name')
                    ->press('Save')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->assertSee('Updated User Name');
        });
    }
    
    /**
     * Test that admin can assign a role to a user.
     */
    public function test_admin_can_assign_role_to_user()
    {
        $testUser = User::factory()->create([
            'name' => 'Role Test User',
            'email' => 'roletest@example.com',
        ]);
        
        // Create a test role
        $testRole = Role::create(['name' => 'editor']);
        
        $this->browse(function (Browser $browser) use ($testUser) {
            $browser->visit('/admin/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    ->clickLink('Users')
                    ->waitForRoute('filament.admin.resources.users.index')
                    ->clickLink('Role Test User')
                    ->waitForRoute('filament.admin.resources.users.edit', ['record' => $testUser->id])
                    ->select('roles', 'editor')
                    ->press('Save')
                    ->waitForRoute('filament.admin.resources.users.index');
                    
            // Verify the role was assigned by checking the database
            $this->assertTrue($testUser->fresh()->hasRole('editor'));
        });
    }
}
