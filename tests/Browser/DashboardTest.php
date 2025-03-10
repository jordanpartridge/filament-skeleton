<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Tests\Browser\Components;
use Tests\Browser\Pages;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Setup the test and create an admin user.
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Create admin role
        $adminRole = Role::create(['name' => 'admin']);
        
        // Create a user with admin role
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $user->assignRole('admin', null);
    }
    
    /**
     * Test that admin can access the dashboard.
     */
    public function test_admin_can_access_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->within(new Components\FilamentLogin, function ($browser) {
                        $browser->login('admin@example.com', 'password');
                    })
                    ->on(new Pages\FilamentDashboard)
                    ->assertSee('Dashboard')
                    ->assertSee('System Stats');
        });
    }
    
    /**
     * Test that admin can navigate to different dashboard pages.
     */
    public function test_admin_can_navigate_to_different_dashboards()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->within(new Components\FilamentLogin, function ($browser) {
                        $browser->login('admin@example.com', 'password');
                    })
                    ->on(new Pages\FilamentDashboard)
                    
                    // Navigate to Pulse Dashboard
                    ->tap(function (Browser $browser) {
                        (new Pages\FilamentDashboard)->navigateToPulse($browser);
                    })
                    ->assertPathIs('/admin/pulse-dashboard')
                    
                    // Navigate back to main dashboard
                    ->visit('/admin')
                    ->on(new Pages\FilamentDashboard)
                    
                    // Navigate to User Dashboard (if available)
                    ->whenAvailable('.fi-sidebar a:contains("User Dashboard")', function ($element) {
                        $element->click();
                    })
                    
                    // Navigate back to main dashboard
                    ->visit('/admin')
                    ->on(new Pages\FilamentDashboard)
                    
                    // Navigate to Security Dashboard (if available)
                    ->whenAvailable('.fi-sidebar a:contains("Security")', function ($element) {
                        $element->click();
                    });
        });
    }
    
    /**
     * Test that admin can see and interact with widgets.
     */
    public function test_admin_can_interact_with_widgets()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    
                    // System Stats widget should be visible
                    ->assertPresent('#system-stats-widget')
                    
                    // Recent Activity widget should be visible
                    ->assertPresent('#recent-activity-widget')
                    
                    // Database widget should be visible
                    ->assertPresent('#database-widget')
                    
                    // Server Health widget should be visible
                    ->assertPresent('#server-health-widget');
        });
    }
}
