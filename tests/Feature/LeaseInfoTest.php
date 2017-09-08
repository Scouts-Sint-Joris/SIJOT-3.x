<?php

namespace Tests\Feature;

use Sijot\{
    Lease, Notitions, Role, User
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithoutMiddleware, DatabaseTransactions, DatabaseMigrations};

/**
 * Class LeaseInfoTest
 *
 * @package Tests\Feature
 */
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
     * @group  all
     */
    public function testMakeLeaseAdminInvalid()
    {
        // TODO: write test.
    }

    /**
     * Test if we can delete a lease admin with an invalid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::deleteAdminPerson()
     */
    public function testDeleteLeaseAdminInvalid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.remove.admin', ['id' => 100000000000]))
            ->assertSessionHas(['flash_notification.0.message' => 'Wij konden de verhuur administrator niet vinden in het systeem.'])
            ->assertStatus(302);
    }

    /**
     * Test àif we can delete a lease admin with some valid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::deleteAdminPerson()
     */
    public function testDeleteAdminLeaseAdminValid()
    {
        factory(Role::class)->create(['name' => 'verhuur']);
        $user = factory(User::class, 2)->create();

        User::find($user[0]->id)->assignRole('verhuur');
        User::find($user[1]->id)->assignRole('verhuur');

        $this->actingAs($user[0])
            ->seeIsAuthenticatedAs($user[0]);

        // TODO: Complete tests.
    }

    /**
     * Test iàs we can delete a lease notition with invalid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::deleteNotition()
     */
    public function testDeleteNotitionInvalid()
    {
        // TODO: write test.
    }

    /**
     * Test if we can delete a notition with some valid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::deleteNotition()
     */
    public function testDeleteNotitionValid()
    {
        $role     = factory(Role::class)->create(['name' => 'verhuur']);
        $user     = factory(User::class)->create();
        $lease    = factory(Lease::class)->create();
        $notition = factory(Notitions::class)->create();

        User::find($user->id)->assignRole($role->name);

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('lease.notitie.delete', ['notitionId' => $notition->id, 'leaseId' => $lease->id]))
            ->assertSessionHas(['flash_notification.0.message' => 'De notitie is verwijderd.'])
            ->assertStatus(302);

        $this->assertDatabaseMissing('Notitions', ['id' => $notition->id]);
    }

    /**
     * Test if we can store a lease without validation errors.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::addNotition()
     */
    public function testCreateNotitionValid()
    {
        $user  = factory(User::class)->create();
        $lease = factory(Lease::class)->create();

        factory(Role::class)->create(['name' => 'verhuur']);
        User::find($user->id)->assignRole('verhuur');

        $input = ['text' => 'Notition placeholder'];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('lease.notitie.add', $lease), $input)
            ->assertSessionHas(['flash_notification.0.message' => 'De notitie is opgeslagen'])
            ->assertStatus(200);

        $this->assertDatabaseHas('notitions', ['author_id' => $user->id, 'text' => 'Notition placeholder']);
    }

    /**
     * test we can store a notition with validation errors.
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\LeaseInfoController::addNotition()
     */
    public function testCreateNotitionInvalid()
    {
        $user = factory(User::class)->create();

        factory(Role::class)->create(['name' => 'verhuur']);
        User::find($user->id)->assignRole('verhuur');

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('lease.notitie.add', ['id' => '']), ['text' => 'Notition'])
            ->assertStatus(200)
            ->assertSessionMissing(['flash_notification.0.message' => 'De notitie is opgeslagen']);

        $this->assertDatabaseMissing('Notitions', ['author_id' => $user->id, 'text' => 'Notition placeholder']);
    }
}
