<?php

namespace Tests\Browser;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws Throwable
     */
    public function test_login()
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs(RouteServiceProvider::HOME);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_login_invalid_password()
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->logout();
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'invalid_password')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_login_invalid_email()
    {
        $this->browse(function ($browser) {
            $browser->logout();
            $browser->visit('/login')
                ->type('email', 'invalid@gmail.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });
    }
}
