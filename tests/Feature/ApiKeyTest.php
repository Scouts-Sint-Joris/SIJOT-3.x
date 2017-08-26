<?php

namespace Tests\Feature;

use Sijot\Role;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiKeyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::makeKey()
     */
    public function testKeyCreateUnAuthorizedAccess()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('api.key.create'), ['service' => 'test'])
            ->assertStatus(403);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::makeKey()
     */
    public function testKeyCreateValidationErrors()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $permUser = User::find($user->id)->assignRole($role->name);

        $this->actingAs($permUser)
            ->seeIsAuthenticatedAs($permUser)
            ->post(route('api.key.create'), ['service' => ''])
            ->assertStatus(200)
            ->assertSessionHasErrors();
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::makeKey()
     */
    public function testKeyCreateNoValidationErrors()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $permUser = User::find($user->id)->assignRole($role->name);

        $this->actingAs($permUser)
            ->seeIsAuthenticatedAs($permUser)
            ->post(route('api.key.create'), ['service' => 'Testing key'])
            ->assertStatus(302);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::deleteKey()
     */
    public function testKeyDeleteValidId()
    {
        // TODO: Write test
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::deleteKey()
     */
    public function testKeyDeleteInvalidId()
    {
        // TODO: wirte test
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiKeyController::deleteKey()
     */
    public function testKeyDeleteUnAuthorized()
    {
        // TODO: Write test
    }
}
