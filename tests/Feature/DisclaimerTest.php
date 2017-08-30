<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithoutMiddleware, DatabaseTransactions, DatabaseMigrations};

class DisclaimerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test if the disclimer page gives error.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\DisclaimerController::index()
     */
    public function testDisclaimerPage()
    {
        $this->get(route('disclaimer'))->assertStatus(200);
    }
}
