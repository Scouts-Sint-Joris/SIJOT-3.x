<?php

namespace Tests\Feature;

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
}
