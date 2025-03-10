<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class FilamentLogin extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'form';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@email' => 'input[name="email"]',
            '@password' => 'input[name="password"]',
            '@submit' => 'button[type="submit"]',
        ];
    }

    /**
     * Login with the given credentials.
     *
     * @param  Browser  $browser
     * @param  string  $email
     * @param  string  $password
     * @return void
     */
    public function login(Browser $browser, $email = 'admin@example.com', $password = 'password')
    {
        $browser->type('@email', $email)
                ->type('@password', $password)
                ->click('@submit')
                ->waitForLocation('/admin');
    }
}