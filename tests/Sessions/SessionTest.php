<?php
namespace Sessions;

use EQM\Models\Settings\Setting;
use EQM\Models\Users\User;

class SessionTest extends \TestCase
{
    /** @test */
    public function login()
    {
        $user = factory(User::class)->create([
            'email' => 'foo@bar.com',
            'activated' => true
        ]);

        factory(Setting::class)->create([
            'user_id' => $user->id
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Sign In')
            ->onPage('/')
            ->dontSee('Welcome to Equimundo');
    }

    /** @test */
    public function logout()
    {
        $user = factory(User::class)->create();

        factory(Setting::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Sign Out')
            ->onPage('/')
            ->see('Welcome to Equimundo');
    }
}