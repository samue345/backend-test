<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;



class RedirectStasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
   
    public function test_same_ip_is_counted_as_single_access_in_total_unique_accesses()
    {
        $redirect = Redirect::factory()->create(['status' => 1]);

        RedirectLog::factory()->count(rand(10, 99))->create([
            'redirect_id' => $redirect->id,
            'ip_request' => '127.0.0.1',
        ]);

        $response = $this->get(route('redirects.stats', $redirect->code));

        $response->assertJson(['unique_ips' => 1]);
    }

    public function test_accesses_in_last_10_days_are_correct()
    {
        $redirect = Redirect::factory()->create(['status' => 1]);

        RedirectLog::factory()->count(10)->create([
            'redirect_id' => $redirect->id,
            'ip_request' => '127.0.0.1',
        ]);

        RedirectLog::factory()->count(2)->create([
            'redirect_id' => $redirect->id,
            'ip_request' => '127.0.0.1',
            'date_access' => now()->addDays(-11)->format('Y-m-d H:i:s'),
        ]);

        $response = $this->get(route('redirects.stats', $redirect->code));

        $response->assertJson([
            'accesses_last_10_days' => [
                'date' => '2024-02-09',
                'total' => 10,
                'total' => 0,
                 'unique' => 0,
            ]
        ]);
    }
    public function test_accesses_in_last_10_days_are_correct_when_no_accesses()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->get(route('redirects.stats', $redirect->code));

        $response->assertJson([
            'accesses_last_10_days' => [
                'date' => now()->addDays(-10)->format('Y-m-d'),
                'total' => 0,
                'unique' => 0,
            ],
        ]);
    }
    public function test_accesses_in_last_10_days_are_correct_when_there_are_accesses()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'date_access' => now()->subDays(3)]);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'date_access' => now()->subDays(9)]);

     
        $response = $this->get(route('redirects.stats', $redirect->code));

        $response->assertJson([
            'accesses_last_10_days' => [
                'date' => now()->addDays(-10)->format('Y-m-d'),
                'total' => 2,
                'unique' => 2,
            ],
        ]);
    }
    public function test_accesses_only_include_last_10_days()
    {
        $redirect = Redirect::factory()->create();

        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'date_access' => now()->subDays(12)]);

        $response = $this->get(route('redirects.stats', $redirect->code));


        $response->assertJson([
            'accesses_last_10_days' => [
                'date' => now()->addDays(-10)->format('Y-m-d'),
                'total' => 0,
                'unique' => 0,
            ],
        ]);
    }

}
