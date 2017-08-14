<?php

namespace Tests\Feature;

use Sijot\Lease;
use Sijot\Role;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeaseInfoTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the response on a valid lease id.
     *
     * @test
     */
    public function testShowLeaseValidId()
    {
        $user       = factory(User::class)->create();
        $leaseRole  = factory(Role::class)->create(['name' => 'verhuur']);
        $lease      = factory(Lease::class)->create();

        $leaseUser = User::findOrfail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->get(route('lease.info.show', $lease))
            ->assertStatus(200);
    }

    /**
     * Test the response on a invalid lease id.
     *
     * @test
     */
    public function testShowLeaseInvalidId()
    {
        $user      = factory(User::class)->create();
        $leaseRole = factory(Role::class)->create(['name' => 'verhuur']);

        $leaseUser = User::findOrfail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->get(route('lease.info.show', ['id' => 1000]))
            ->assertSessionHas(['flash_notification.0.message'   => 'Wij konden de verhuring niet vinden in het systeem.'])
            ->assertStatus(302);
    }

    /**
     * Try to update a lease with an invalid id.
     *
     * @test
     */
    public function testUpdateLeaseInvalidId()
    {
        $user      = factory(User::class)->create();
        $leaseRole = factory(Role::class)->create(['name' => 'verhuur']);
        $lease     = factory(Lease::class)->create(['id' => 1]);

        $leaseUser = User::findOrFail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->post(route('lease.info.update', ['id' => 1000]))
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function testUpdateLeaseValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testUpdateLeaseValidIdValidatoionErrors()
    {
        // TODO: Write test
    }

    /**
     * @test
     */
    public function testMakeLeaseAdminValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testMakeLeaseAdminInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testDeleteLeaseAdminInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testDeleteAdminLeaseAdminValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testDeleteNotitionInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testDeleteNotitionValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testCreateNotitionValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     */
    public function testCreateNotitionInvalid()
    {
        // TODO: write test.
    }
}
