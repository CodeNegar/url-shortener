<?php

namespace Tests\Unit;

use App\Url;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function it_should_increase_visits_field_by_one_when_a_short_url_is_accessed()
    {
        // Given the urls table has a record
        $row = factory(\App\Url::class)->create([
            'visits' => 0
        ]);

        $row->toArray();

        // When the short url is accessed
        $url = route('go', $row->id);
        $response = $this->get($url);

        // Then number of visits should be increased by 1
        $updated_url = Url::find($row->id);
        $this->assertEquals(1, $updated_url->visits);
    }
}
