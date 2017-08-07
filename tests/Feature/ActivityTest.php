<?php

namespace Tests\Feature;

use Sijot\Activity;
use Sijot\Groups;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    /**
     * Test the backend route for the activities
     *
     * @test
     * @group all
     */
    public function testBackendRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.backend'))
            ->assertStatus(200);
    }

    /**
     * Test the activity creation (with validation error.)
     *
     * @test
     * @group all
     */
    public function testStoreWithError()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('activity.store'), [])
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'message' => trans('activity.flash-store-success', ['title' => ''])
            ]);
    }

    /**
     * Test the activity creation (no validation error.)
     *
     * @test
     * @group all
     */
    public function testStoreNoError()
    {
        $group = factory(Groups::class)->create();
        $user  = factory(User::class)->create();

        $input = [
            'group_id'          => $group->id,
            'status'            => 0,
            'title'             => 'Ik ben een titel',
            'activiteit_datum'  => '10-10-1995',
            'start_hour'        => '01:00',
            'end_hour'          => '02:00',
            'description'       => 'Ik ben een beschrijving'
       ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('activity.store'), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.message' => trans('activity.flash-store-success', ['title' => $input['title']])
            ]);

        // $this->assertDatabaseHas('activities', $input);
    }

    /**
     * Test if we can get a json response for a specific activity.
     *
     * @test
     * @group all
     */
    public function testGetByIdValid()
    {
        $user     = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.json', ['id' => $activity->id]))
            ->assertStatus(200)
            ->json();
    }

    /**
     * Test the response if we can get a json response when the id is invalid.
     *
     * @test
     * @group all
     */
    public function testGetByIdInvalid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.json', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Try to change the status of an invalid activity id.
     *
     * @test
     * @group all
     */
    public function testStatusInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.status', ['status', 0, 'id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Try to set an activity to draft.
     *
     * @test
     * @group all
     */
    public function testStatusDraft()
    {
        $user     = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.status', ['status' => 0, 'id' => $activity->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.level'   => 'success',
                'flash_notification.0.message' => trans('activity.flash-status-draft', ['title' => $activity->title])
            ]);
    }

    /**
     * Try to set an activity to publish
     *
     * @test
     * @group all
     */
    public function testStatusPublish()
    {
        $user     = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.status', ['status' => 1, 'id' => $activity->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.message' => trans('activity.flash-status-publish', ['title' => $activity->title])
            ]);
    }

    /**
     * Try to show an activity.
     *
     * @test
     * @group all
     */
    public function testShowNoError()
    {
        $user     = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.show', ['id' => $activity->id]))
            ->assertStatus(200);
    }

    /**
     * Try to show an incorrect activity.
     *
     * @test
     * @group all
     */
    public function testShowError()
    {
        $user     = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.show', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Delete event error
     *
     * @test
     * @group all
     */
    public function testDeleteError()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.delete', ['id' => 1000000]))
            ->assertStatus(404);
    }

    /**
     * Delete event success.
     *
     * @test
     * @group all
     */
    public function testDeleteSuccess()
    {
        $user     = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('activity.delete', ['id' => $activity->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.message' => trans('activity.flash-delete-success', ['title' => $activity->title])
            ]);

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }
}
