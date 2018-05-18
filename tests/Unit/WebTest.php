<?php

namespace Tests\Unit;

use App\Http\Controllers\UrlController;
use App\Url;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function it_should_increase_hits_field_by_one_when_a_short_url_is_accessed()
    {
        // Given the urls table has a record
        $row = factory(\App\Url::class)->create([
            'hits' => 0
        ]);

        $row->toArray();

        // When the short url is accessed
        $url = route('go', $row->id);
        $response = $this->get($url);

        // Then number of hits should be increased by 1
        $updated_url = Url::find($row->id);
        $this->assertEquals(1, $updated_url->hits);
    }

    /** @test */

    public function it_should_save_visit_details_when_a_short_url_is_accessed()
    {
        // Given the urls table has a record
        $row = factory(\App\Url::class)->create([
            'hits' => 0
        ]);

        $row->toArray();

        // When the short url is accessed using Firefox on Windows user agent
        $url = route('go', $row->id);

        $response = $this->withHeaders([
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
        ])->get($url);

        // Then visit details should be inserted with firefox and windows
        $visit_log = Visit::where('url_id', $row->id)->first();
        $this->assertContains('Firefox', $visit_log->client_name);
        $this->assertContains('Windows', $visit_log->os);
    }
    /** @test */

    public function it_should_give_correct_hit_count_for_each_time_period()
    {
        // Given the urls table has a record
        $url_row = factory(\App\Url::class)->create([
            'hits' => 0
        ]);

        // Mock current time, Thursday
        Carbon::setTestNow(Carbon::create(2018, 5, 17, 10, 45, 4));

        // Three visits today
        $row = factory(\App\Visit::class, 3)->create([
            'created_at' => Carbon::now()->startOfDay()->addSeconds(rand(100, 86000)),
            'url_id' => $url_row->id
        ]);

        // two visits yesterday
        $row = factory(\App\Visit::class, 2)->create([
            'created_at' => Carbon::now()->startOfDay()->subDays(1)->addSeconds(rand(100, 80000)),
            'url_id' => $url_row->id
        ]);

        // four visits 9 days ago
        $row = factory(\App\Visit::class, 4)->create([
            'created_at' => Carbon::now()->startOfDay()->subDays(9)->addSeconds(rand(100, 80000)),
            'url_id' => $url_row->id
        ]);

        // seven visits 45 days ago
        $row = factory(\App\Visit::class, 7)->create([
            'created_at' => Carbon::now()->startOfDay()->subDays(45)->addSeconds(rand(100, 80000)),
            'url_id' => $url_row->id
        ]);

        // Then visit details should be: day: 3, week: 5, month: 9, all: 16
        $urlController = new UrlController();
        $stats = $urlController->stats($url_row);

        $this->assertEquals(3,  $stats['day']['hits']);
        $this->assertEquals(5,  $stats['week']['hits']);
        $this->assertEquals(9,  $stats['month']['hits']);
        $this->assertEquals(16,  $stats['all']['hits']);
    }
}
