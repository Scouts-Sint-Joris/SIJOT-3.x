<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class UsersTest
 *
 * @package Tests\Feature
 */
class UsersTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the index route for the user section.
     *
     * @test
     * @group all
     */
    public function testUsersIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.index'))
            ->assertStatus(200);
    }

    /**
     * Test if we can get a specific user.
     *
     * @test
     * @group all
     */
    public function testGetByValidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.getId', $user->id))
            ->assertStatus(200)
            ->json();
    }

    /**
     * Test if we can get an 404 on a invalid user request.
     *
     * @test
     * @group all
     */
    public function testGetByInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.getId', 1000))
            ->assertStatus(404);
    }

    /**
     * Test if we can ban a user. Without validation errors.
     *
     * @test
     * @group all
     */
    public function testBanUserValidIdNoValidationError()
    {

    }

    /**
     *
     */
    public function testBanUserValidIdValidationError()
    {

    }

    public function testBanUserInvalidId()
    {

    }

    public function testUnblockValidId()
    {

    }

    public function testUnblockInvalidId()
    {

    }

    public function testStoreValidationError()
    {

    }

    public function testStoreNoValidationErr()
    {

    }

    public function testUserDeleteValidId()
    {

    }

    public function testUserDeleteInvalidId()
    {

    }
}
