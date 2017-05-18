<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testNewMemberInformation()
    {
        $this->get(route('members.new'))->assertStatus(200);
    }
}
