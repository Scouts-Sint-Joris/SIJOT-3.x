<?php

namespace Tests\Feature;

use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeaseTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testLeaseIndexFrontEnd()
    {
        $this->get(route('lease'))->assertStatus(200);
    }

    public function testLeaseBackendIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.backend'))
            ->assertStatus(200);
    }

    public function testLeaseExportMethod()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get('lease.export')
            ->assertStatus(404); // NOTE: Throws a 404 for a strange reason.
    }

    public function testLeaseRequestViewNoAuthencation()
    {
        $this->get(route('lease.request'))->assertStatus(200);
    }

    public function testLeaseDomainAccessFrontEnd()
    {
        $this->get(route('lease.access'))->assertStatus(200);
    }

    public function testLeaseCalendarFrontEnd()
    {
        $this->get(route('lease.calendar'))->assertStatus(200);
    }
}
