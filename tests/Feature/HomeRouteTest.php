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

    /**
     * Test the front-end home route.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\HomeController::index()
     */
    public function testFrontEndRoute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test the back-end home route.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\HomeController::backend()
     */
    public function testBackendRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('backend'))
            ->assertStatus(200);
    }
}
