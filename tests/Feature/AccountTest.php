<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class AccountTest
 *
 * @package Tests\Feature
 */
class AccountTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the account index route.
     *
     * @test
     * @group all
     */
    public function testAccountIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('account'))
            ->assertStatus(200);
    }

    /**
     * Test the account information update method (With validation errors)
     *
     * @test
     * @group all
     */
    public function testAccountSettingsUpdateWithValidationErr()
    {
        $user  = factory(User::class)->create();
        $input = ['user_id' => $user->id];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('account.info'), $input)
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'class'   => 'alert alert-success',
                'message' => trans('account.flash-account-info')
            ]);
    }

    /**
     * Test the user update method for an account. (Without the validation errors)
     *
     * @test
     * @group all
     */
    public function testAccountSettingsWithoutValidationErr()
    {
        $user = factory(User::class)->create();

        $input = [
            'user_id' => $user->id,
            'theme'   => 1,
            'email'   => 'janmetdepet@gmail.com',
            'name'    => 'Jan met de pet',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('account.info'), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => trans('account.flash-account-info')
            ]);
    }

    /**
     * Test the account password update (without validation errors)
     *
     * @test
     * @group all
     */
    public function testAccountPasswordWithoutValidationErr()
    {
        $user = factory(User::class)->create();

        $input = [
            'user_id'               => $user->id,
            'password'              => 'IkBenEenWachtwoord',
            'password_confirmation' => 'IkBenEenWachtwoord'
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('account.security'), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => trans('account.flash-account-password')
            ]);
    }

    /**
     * Test the account password update (with validation errors)
     *
     * @test
     * @group all
     */
    public function testAcccountPasswordWithValidationErr()
    {
        $user  = factory(User::class)->create();
        $input = ['user_id' => $user->id];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('account.security'), $input)
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'class'   => 'alert alert-success',
                'message' => trans('account.flash-account-password')
            ]);
    }
}
