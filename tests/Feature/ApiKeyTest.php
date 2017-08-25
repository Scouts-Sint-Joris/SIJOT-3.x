<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiKeyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testKeyCreateUnAuthorizedAccess()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('api.key.create'), ['service' => 'test'])
            ->assertStatus(403);
    }

    public function testKeyCreateValidationErrors()
    {

    }

    public function testKeyCreateNoValidationErrors()
    {

    }

    public function testKeyDeleteAuthorizedAccess()
    {

    }

    public function testKeyDeleteInvalidId()
    {

    }

    public function testKeyDeleteValidId()
    {

    }
}
