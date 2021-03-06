<?php

namespace Tests\Unit;

use App\Http\Controllers\UrlController;
use App\Url;
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
        ])->json('POST', '/api/urls', ['bad_field' => 'http://test.com']);

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
        ])->json('POST', '/api/urls', ['longurl' => 'non url data']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);
    }

    /** @test */

    public function it_should_return_ok_when_longurl_parameter_contains_a_valid_url()
    {
        $this->withoutEvents();
        $response = $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/urls', ['longurl' => 'http://example.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'URL successfuly shortened.'
            ]);
    }


    /** @test */

    public function it_should_return_short_url_key_with_value_when_shortening_a_url()
    {
        $this->withoutEvents();
        $response = $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/urls', ['longurl' => 'http://example.com']);

        $response_array = $response->original;

        $this->assertArrayHasKey('data', $response_array);
        $this->assertArrayHasKey('short_url', $response_array['data']);
        $this->assertNotEmpty($response_array['data']['short_url']);
    }

    /** @test */

    public function it_should_create_a_db_record_when_longurl_parameter_contains_a_valid_url()
    {
        // Given the urls table is empty
        $this->assertEquals(0, Url::count());

        // When sending an api call with correct fields
        $this->withHeaders([
            'X-Header' => 'test',
        ])->json('POST', '/api/urls', ['longurl' => 'http://example.com']);

        // Then urls table should contain one record
        $this->assertEquals(1, Url::count());
    }

    /** @test */

    public function it_should_return_redirect_response_when_a_short_url_is_accessed()
    {
        // Given the urls table has a record
        $row = factory(\App\Url::class)->create();
        $row->toArray();

        // When the short url is accessed
        $url = route('go', $row->id);
        $response = $this->get($url);

        // Then it should return a temporary redirect (302)
        $response->assertStatus(302);
    }

    /** @test */

    public function it_should_return_not_found_response_when_a_short_url_with_bad_id_is_accessed()
    {
        // Given the urls table has no record
        Url::truncate();

        // When a short url with bad id is accessed
        $url = route('go', 1);
        $response = $this->get($url);

        // Then it should return not found response (404)
        $response->assertStatus(404);
    }

    /** @test */

    public function it_should_return_list_of_short_urls_when_index_api_is_requested()
    {
        // Given the urls table has 3 records
        $rows = factory(\App\Url::class, 3)->create();
        $rows->toArray();

        // When list of short urls is requested
        $response = $this->json('GET', '/api/urls');

        // Then it should return 3 items
        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */

    public function it_should_return_encoded_number_when_next_row_id_is_requested()
    {
        // Given the next row id is 1 and allowed chars are defined as
        $next_id = 761;
        putenv('URL_SHORTENER_CHARS=0123456789abcdefghijklmnopqrstuv');

        // When next id method is requested
        $url_controller = new UrlController();
        $encoded_number = $url_controller->get_next_id($next_id);

        // Then it should return 'o' as the result
        $this->assertEquals('np', $encoded_number);

        // more scenarios
        $next_id = 1587;
        $encoded_number = $url_controller->get_next_id($next_id);
        $this->assertEquals('1hj', $encoded_number);

        putenv('URL_SHORTENER_CHARS=0123456789abcdefgh');
        $next_id = 1587;
        $encoded_number = $url_controller->get_next_id($next_id);
        $this->assertEquals('4g3', $encoded_number);

        putenv('URL_SHORTENER_CHARS=YVmgRnwkfHGhz8Cr4MW2SE50ZNspobeUPJtvuQOiKl3Aa6LDIXjF7Bc1dqxyT9');
        $next_id = 1587;
        $encoded_number = $url_controller->get_next_id($next_id);
        $this->assertEquals('NQ', $encoded_number);

        putenv('URL_SHORTENER_CHARS=YVmgRnwkfHGhz8Cr4MW2SE50ZNspobeUPJtvuQOiKl3Aa6LDIXjF7Bc1dqxyT9');
        $next_id = 45687542;
        $encoded_number = $url_controller->get_next_id($next_id);
        $this->assertEquals('gnAN7', $encoded_number);
    }


    /** @test */

    public function it_should_return_single_url_details_including_hidden_long_url_when_single_url_api_is_requested()
    {
        // Given the urls table has a record
        $row = factory(\App\Url::class)->create();
        $row->toArray();

        // When details of that short url is requested
        $response = $this->json('GET', '/api/urls/' . $row->id);

        // Then it should return a json containing details
        $response->assertStatus(200);

        $response_arr = json_decode($response->content(), true);
        $this->assertArrayHasKey('short_url', $response_arr);
        $this->assertArrayHasKey('hits', $response_arr);
        $this->assertArrayHasKey('url', $response_arr);
        $this->assertNotEmpty($response_arr['url']);
        $this->assertNotEmpty($response_arr['short_url']);

    }
}
