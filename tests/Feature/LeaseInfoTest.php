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
     * @group all
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
     * @group all
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
     * @group all
     */
    public function testUpdateLeaseInvalidId()
    {
        $user      = factory(User::class)->create();
        $leaseRole = factory(Role::class)->create(['name' => 'verhuur']);

        //> Input
        $input['status_id']     = 1;
        $input['start_datum']   = '2019-10-10';
        $input['eind_datum']    = '2019-11-10';
        $input['contact_email'] = 'name@domain.tld';
        $input['groeps_naam']   = 'Sint-Joris Turnhout';
        //> END input

        $leaseUser = User::findOrFail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->post(route('lease.info.update', ['id' => 1000]), $input)
            ->assertSessionHas(['flash_notification.0.message'   => 'Wij konden de informatie omtrent de verhuringen niet vinden.'])
            ->assertRedirect(route('lease.backend'));
    }

    /**
     * Test a valid lease update.
     *
     * @test
     * @group all
     */
    public function testUpdateLeaseValid()
    {
        $user       = factory(User::class)->create();
        $leaseRole  = factory(Role::class)->create(['name' => 'verhuur']);
        $lease      = factory(Lease::class)->create();

        $leaseUser = User::findOrFail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        //> Input
        $input['status_id']     = 1;
        $input['start_datum']   = '2019-10-10';
        $input['eind_datum']    = '2019-11-10';
        $input['contact_email'] = 'name@domain.tld';
        $input['groeps_naam']   = 'Sint-Joris Turnhout';
        //> END input

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->post(route('lease.info.update', $lease), $input)
            ->assertSessionHas(['flash_notification.0.message' => 'De informatie omtrent de verhuring is aangepast.'])
            ->assertRedirect(route('lease.info.show', $lease));
    }

    /**
     * Test the validation errors when we try to update a lease.
     *
     * @test
     * @group all
     */
    public function testUpdateLeaseValidIdValidationErrors()
    {
        $user       = factory(User::class)->create();
        $leaseRole  = factory(Role::class)->create(['name' => 'verhuur']);
        $lease      = factory(Lease::class)->create();

        $leaseUser = User::findOrFail($user->id);
        $leaseUser->assignRole($leaseRole->name);

        $this->assertTrue($leaseUser->hasRole('verhuur'));

        $this->actingAs($leaseUser)
            ->seeIsAuthenticatedAs($leaseUser)
            ->post(route('lease.info.update', $lease))
            ->assertStatus(200)
            ->assertSessionHasErrors();
    }

    /**
     * @test
     * @group all
     */
    public function testMakeLeaseAdminValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testMakeLeaseAdminInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testDeleteLeaseAdminInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testDeleteAdminLeaseAdminValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testDeleteNotitionInvalid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testDeleteNotitionValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testCreateNotitionValid()
    {
        // TODO: write test.
    }

    /**
     * @test
     * @group all
     */
    public function testCreateNotitionInvalid()
    {
        // TODO: write test.
    }
}
