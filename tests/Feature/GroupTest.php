<?php

namespace Tests\Feature;

use Sijot\Groups;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the group index page
     *
     * @test
     * @group all
     */
    public function testIndex()
    {
        $this->get(route('groups.index'))
            ->assertStatus(200);
    }

    /**
     * Test The backend route.
     *
     * @test
     * @group all
     */
    public function testBackendIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('groups.backend'))
            ->assertStatus(200);
    }

    /**
     * Try to update a group (with validation errors)
     *
     * @test
     * @group all
     */
    public function testUpdateValidationErrors()
    {
        $user  = factory(User::class)->create();
        $group = factory(Groups::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('groups.update', ['id' => $group->id]))
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'class'   => 'alert alert-success',
                'message' => 'De groeps informatie is aangepast.'
            ]);
    }

    /**
     * Try to update a group (without validation errors)
     *
     * @test
     * @group all
     */
    public function testUpdateSuccess()
    {
        $user  = factory(User::class)->create();
        $group = factory(Groups::class)->create();

        $old = [
            'title'       => $group->title,
            'sub_title'   => $group->sub_title,
            'description' => $group->description,
        ];

        $input = [
            'title'       => 'Ik ben een title',
            'sub_title'   => 'Ik ben een sub titel',
            'description' => 'Ik ben een beschrijving',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('groups.update', ['id' => $group->id]), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => 'De groeps informatie is aangepast.'
            ]);

        $this->assertDatabaseHas('groups', $input);
        $this->assertDatabaseMissing('groups', $old);
    }

    /**
     * Try to update a group (no valid id)
     *
     * @test
     * @group all
     */
    public function testUpdateNoValidId()
    {
        $user  = factory(User::class)->create();

        $input = [
            'title'       => 'Ik ben een title',
            'sub_title'   => 'Ik ben een sub titel',
            'description' => 'Ik ben een beschrijving',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('groups.update', ['id' => 1000]), $input)
            ->assertStatus(404)
            ->assertSessionMissing([
                'class'   => 'alert alert-success',
                'message' => 'De groeps informatie is aangepast.'
            ]);
    }

    /**
     * Show a specific group (no valid id)
     *
     * @test
     * @group all
     */
    public function testShowGroupNoValidId()
    {
        $this->get(route('groups.show', ['selector' => 'BladeBlad']))
            ->assertStatus(404);
    }

    /**
     * Show a specific group
     *
     * @test
     * @group all
     */
    public function testShowGroup()
    {
        $group = factory(Groups::class)->create();

        $this->get(route('groups.show', ['selector' => $group->selector]))
            ->assertStatus(200);
    }
}
