<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the page with the information for a new member.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\MemberController::index()
     */
    public function testNewMemberInformation()
    {
        $this->get(route('members.new'))->assertStatus(200);
    }
}
