<?php

namespace Tests\Browser;

use App\Common\Enums\Status;
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
            $browser->visit(route('login'))
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/' . RouteServiceProvider::HOME);
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
            $browser->visit(route('login'))
                ->type('email', $user->email)
                ->type('password', 'invalid_password')
                ->press('Login')
                ->assertCookieValue('type', Status::DANGER);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_login_invalid_email()
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit(route('login'))
                ->type('email', $user->email . 'invalid')
                ->type('password', 'invalid_email')
                ->press('Login')
                ->assertCookieValue('type', Status::DANGER);
        });
    }
}
