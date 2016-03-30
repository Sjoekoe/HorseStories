<?php
namespace Controllers\Sessions;

use EQM\Models\Users\EloquentUser;

class SessionTest extends \TestCase
{
    /** @test */
    public function login()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Sign In')
            ->seePageIs('/')
            ->dontSee('Welcome to Equimundo');
    }

    /** @test */
    public function it_can_not_login_when_the_user_is_not_activated()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
            'activated' => false,
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Sign In')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    public function it_can_not_login_with_a_wrong_password()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('foobar', 'password')
            ->press('Sign In')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    function it_can_not_login_with_a_wrong_email_address()
    {
        $user = factory(EloquentUser::class)->create([
            'email' => 'foo@bar.com',
        ]);

        $this->visit('/login')
            ->type('wrong@email.com', 'email')
            ->type($user->password, 'password')
            ->press('Sign In')
            ->seePageIs('/login')
            ->see('These credentials do not match our records, or your account has not been activated.');
    }

    /** @test */
    public function logout()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Logout')
            ->seePageIs('/login')
            ->see('The social network for horses.');
    }
}
