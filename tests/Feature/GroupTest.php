<?php

namespace Tests\Feature;

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
}
