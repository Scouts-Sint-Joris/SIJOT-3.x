<?php

namespace Tests\Feature;

use Sijot\Events;
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
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::index()
     */
    public function testIndexRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('events.index'))
            ->assertStatus(200);
    }

    /**
     * Test event creation in the database (with validation errors).
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::store()
     */
    public function testEventStoreWithValidationErr()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('events.store'), [])
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing(['flash_notification.0.message' => trans('events.flash-event-create')]);
    }

    /**
     * Test event creation in the database (without validation errors).
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::store()
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
            ->assertSessionHasAll(['flash_notification.0.message' => trans('events.flash-event-create')]);

        $this->assertDatabaseHas('events', [
            'author_id'     => $user->id,
            'title'         => 'Ik ben een titel',
            'description'   => 'Ik ben een beschrijving',
        ]);
    }

    /**
     * Test the response when an event id is valid.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::show()
     */
    public function testShowEventValidId()
    {
        $event = factory(Events::class)->create(['id' => 4]);

        $this->get(route('events.show', $event->id))
            ->assertStatus(200);
    }

    /**
     * Test the response when an event id in invalid.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::show()
     */
    public function testShowEventInvalidId()
    {
        $this->get(route('events.show', 1000))
            ->assertStatus(404);
    }

    /**
     * Test the event status with an invalid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::status()
     */
    public function testEventStatusInvalidId()
    {
        $event  = factory(Events::class)->create(['id' => 1]);
        $user   = factory(User::class)->create();
        $params = ['status' => 0, 'id' => 1000];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('events.status', $params))
            ->assertStatus(404);
    }

    /**
     * Test if an event can be converted to draft.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::status()
     */
    public function testEventStatusDraft()
    {
        $event  = factory(Events::class)->create();
        $user   = factory(User::class)->create();
        $params = ['status' => 0, 'id' => $event->id];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('events.status', $params))
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => trans('events.flash-event-draft')]);
    }

    /**
     * Test if an event can be published
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\EventsController::status()
     */
    public function testEventPublish()
    {
        $event  = factory(Events::class)->create();
        $user   = factory(User::class)->create();
        $params = ['status' => 1, 'id' => $event->id];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('events.status', $params))
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => trans('events.flash-publish')]);
    }
}
