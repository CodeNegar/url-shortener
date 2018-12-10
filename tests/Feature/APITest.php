<?php

namespace Tests\Unit;

use Tests\TestCase;

class APITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200);
    }
}
