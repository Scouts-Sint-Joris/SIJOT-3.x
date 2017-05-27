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

    public function testEventStoreWithValidationErr()
    {

    }

    /**
     * Test event creation in the database (without validation errors).
     *
     * @test
     * @group all
     */
    public function testEventStoreWithoutValidationErr()
    {
        $user = factory(User::class)->create();

        $input = [
            'author_id'     => $user->id,
            'title'         => 'Ik ben een titel',
            'description'   => 'Ik ben een beschrijving',
            'start_date'    => '10/10/1995',
            'end_date'      => '11/10/1996',
            'status'        => 'Y',
            'end_hour'      => '10:10',
            'start_hour'    => '12:10',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('events.store'), $input)
            ->assertStatus(302)
            ->assertSessionHasAll([
                'class'   => 'alert alert-success',
                'message' => trans('events.flash-event-create'),
            ]);
    }
}
