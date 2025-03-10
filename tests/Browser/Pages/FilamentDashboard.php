<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class FilamentDashboard extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@navigation' => 'nav',
            '@sidebar' => '.fi-sidebar',
            '@content' => '.fi-main',
            '@user-menu' => '.fi-user-menu',
        ];
    }

    /**
     * Navigate to the users page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function navigateToUsers(Browser $browser)
    {
        $browser->clickLink('Users')
                ->waitForRoute('filament.admin.resources.users.index');
    }

    /**
     * Navigate to the roles page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function navigateToRoles(Browser $browser)
    {
        $browser->clickLink('Roles')
                ->waitForRoute('filament.admin.resources.roles.index');
    }

    /**
     * Navigate to the pulse dashboard.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function navigateToPulse(Browser $browser)
    {
        $browser->clickLink('Pulse')
                ->waitForRoute('filament.admin.pages.pulse-dashboard');
    }

    /**
     * Navigate to the user dashboard.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function navigateToUserDashboard(Browser $browser)
    {
        $browser->clickLink('User Dashboard')
                ->waitForRoute('filament.admin.pages.user-dashboard');
    }

    /**
     * Logout from the application.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function logout(Browser $browser)
    {
        $browser->click('@user-menu')
                ->clickLink('Sign out')
                ->waitForRoute('filament.admin.auth.login');
    }
}