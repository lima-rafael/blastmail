<?php

namespace Tests\Feature;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_exemple()
    {
        $this->assertDatabaseCount('users', 2);
        // $this->assertTrue(true);
    }
}