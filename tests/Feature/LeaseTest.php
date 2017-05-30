<?php

namespace Tests\Feature;

use Sijot\Lease;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeaseTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the front-end page for the leases.
     *
     * @test
     * @group all
     */
    public function testLeaseIndexFrontEnd()
    {
        $this->get(route('lease'))->assertStatus(200);
    }

    /**
     * Test the backend index page for the leases.
     *
     * @test
     * @group all
     */
    public function testLeaseBackendIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.backend'))
            ->assertStatus(200);
    }

    /**
     * T6est the export method for the leases.
     *
     * @group all
     * @test
     */
    public function testLeaseExportMethod()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.export'))
            ->assertStatus(200);
    }

    /**
     * Test the front-end lease request page.
     *
     * @test
     * @route all
     */
    public function testLeaseRequestViewNoAuthencation()
    {
        $this->get(route('lease.request'))->assertStatus(200);
    }

    /**
     * The Domain Access page.
     *
     * @test
     * @group all
     */
    public function testLeaseDomainAccessFrontEnd()
    {
        $this->get(route('lease.access'))->assertStatus(200);
    }

    /**
     * Try to delete an invalid lease.
     *
     * @test
     * @group all
     */
    public function testLeaseDeleteInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.delete', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * try to delete a valid lease.
     *
     * @test
     * @group all
     */
    public function testLeaseDelete()
    {
        $user  = factory(User::class)->create();
        $lease = factory(Lease::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.delete', ['id' => $lease->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => trans('lease.flash-lease-delete')
            ]);
    }

    /**
     * The the front-end lease calendar.
     * 
     * @test
     * @group all
     */
    public function testLeaseCalendarFrontEnd()
    {
        $this->get(route('lease.calendar'))->assertStatus(200);
    }
}
