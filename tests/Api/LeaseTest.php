<?php

namespace Tests\Api;

use Chrisbjr\ApiGuard\Models\ApiKey;
use Sijot\Lease;
use Tests\TestCase;
use Illuminate\Foundation\Testing\{DatabaseMigrations, DatabaseTransactions};

/**
 * Class LeaseTest
 *
 * @package Tests\Api
 */
class LeaseTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::index()
     */
    public function testIndexLeaseUnauthorized()
    {
        $this->get('api/lease', ['X-Authorization' => 'No Key'])
            ->assertStatus(401)
            ->assertJson(["error" => ["code" => "401", "http_code" => "GEN-UNAUTHORIZED", "message" => "Unauthorized."]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::index()
     */
    public function testIndexLeaseAuthorized()
    {
        $api = factory(ApiKey::class)->create();
        $this->get('api/lease', ['X-Authorization' => $api->key])->assertStatus(200);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::show()
     */
    public function testShowLeaseUnauthorized()
    {
        $lease = factory(Lease::class)->create();

        $this->get(route('lease.show', $lease))
            ->assertStatus(401)
            ->assertJson(["error" => ["code" => "401", "http_code" => "GEN-UNAUTHORIZED", "message" => "Unauthorized."]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::show()
     */
    public function testShowLeaseAuthorized()
    {
        $lease = factory(Lease::class)->create();
        $api   = factory(ApiKey::class)->create();

        $this->get(route('lease.show', $lease), ['X-Authorization' => $api->key])->assertStatus(200);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::store()
     */
    public function testLeaseCreateAuthorizedValidationErrors()
    {
        $api = factory(ApiKey::class)->create();

        $this->post('api/lease', [], ['X-Authorization' => $api->key, 'Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::store()
     */
    public function testLeaseCreateAuthorizedNoValidationErrors()
    {
        $api = factory(ApiKey::class)->create();

        $input = [
            'status_id'     => 1,
            'start_datum'   => '2018-10-10',
            'eind_datum'    => '2018-11-11',
            'contact_email' => 'name@domain.tld',
            'groeps_naam'   => 'My Local scouting group'
        ];

        $this->post('api/lease', $input, ['X-Authorization' => $api->key])
            ->assertStatus(200)
            ->assertJson(["error" => ["code" => "GEN-CREATED", "http_code" => 200, "message" => trans('api.lease-create-success'),]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::store()
     */
    public function testLeaseCreateUnauthorized()
    {
        $this->post('api/lease', [], ['X-Authorization' => ''])
            ->assertStatus(401)
            ->assertJson(["error" => ["code" => "401", "http_code" => "GEN-UNAUTHORIZED", "message" => "Unauthorized."]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::destroy()
     */
    public function testLeaseDeleteAuthorized()
    {
        $lease = factory(Lease::class)->create();
        $api   = factory(ApiKey::class)->create();

        $this->delete(route('lease.destroy', $lease), [], ['X-Authorization' => $api->key])
            ->assertStatus(200)
            ->assertJson(["error" => ["code" => "GEN-NOT-FOUND", "http_code" => 200, "message" => trans('api.lease-destroy-success')]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::destroy()
     */
    public function testLeaseDeleteUnAuthorized()
    {
        $lease = factory(Lease::class)->create();

        $this->delete(route('lease.destroy', ['id' => $lease->id]), [], ['X-Authorization' => 'No key'])
            ->assertStatus(401)
            ->assertJson(["error" => ["code" => "401", "http_code" => "GEN-UNAUTHORIZED", "message" => "Unauthorized."]]);
    }

    /**
     * @test
     * @covers \Sijot\Http\Controllers\ApiV1\LeaseController::destroy()
     */
    public function testLeaseDeleteNoResource()
    {
        $api = factory(ApiKey::class)->create();

        $this->delete(route('lease.destroy', ['id' => 4000]), [], ['X-Authorization' => $api->key])
            ->assertStatus(404)
            ->assertJson(["error" => ["code" => "GEN-NOT-FOUND", "http_code" => 404, "message" => "Resource Not Found",]]);
    }
}
