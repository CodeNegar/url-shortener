<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function it_should_return_error_when_longurl_parameter_doesnt_exist()
    {
        $response = $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/store', ['bad_field' => 'http://test.com']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);
    }

    /** @test */

    public function it_should_return_error_when_longurl_parameter_is_not_a_valid_url()
    {
        $response = $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/store', ['longurl' => 'non url data']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);
    }

    /** @test */

    public function it_should_return_ok_when_longurl_parameter_contains_a_valid_url()
    {
        $response = $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/store', ['longurl' => 'http://example.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'URL successfuly shortened.'
            ]);
    }
}
