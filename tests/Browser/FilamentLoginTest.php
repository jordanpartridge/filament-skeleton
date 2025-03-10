<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FilamentLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function test_user_can_view_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->assertSee('Sign in to your account')
                    ->assertSee('Email')
                    ->assertSee('Password');
        });
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->press('Sign in')
                    ->waitForLocation('/admin')
                    ->assertPathIs('/admin');
        });
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'wrong@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('Sign in')
                    ->assertSee('These credentials do not match our records');
        });
    }
}
