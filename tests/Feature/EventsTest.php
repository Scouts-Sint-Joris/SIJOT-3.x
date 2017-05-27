<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the backend routes for the events section.
     *
     * @test
     * @group all
     */
    public function testIndexRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('events.index'))
            ->assertStatus(200);
    }
}
