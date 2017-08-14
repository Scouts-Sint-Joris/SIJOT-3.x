<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeRouteTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testFrontEndRoute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testBackendRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('backend'))
            ->assertStatus(200);
    }
}
