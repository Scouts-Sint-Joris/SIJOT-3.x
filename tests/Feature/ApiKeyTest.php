<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiKeyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testUnauthorizedAccessIndex()
    {

    }

    public function testKeyCreateUnAuthorizedAccess()
    {

    }

    public function testKeyCreateValidationErrors()
    {

    }

    public function testKeyCreateNoValidationErrors()
    {

    }

    public function testKeyDeleteAuthorizedAccess()
    {

    }

    public function testKeyDeleteInvalidId()
    {

    }

    public function testKeyDeleteValidId()
    {

    }
}
