<?php

namespace Tests\Feature;

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
                'class'   => 'alert alert-success',
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
       $input = [
           'group_id'          => 'required',
           'status'            => 'required',
           'title'             => 'required',
           'activiteit_datum'  => 'required',
           'start_hour'        => 'required',
           'end_hour'          => 'required',
           'description'       => 'required'
       ];
    }
}
