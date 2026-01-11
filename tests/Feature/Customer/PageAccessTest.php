<?php

namespace Tests\Feature\Customer;

use App\Models\Medicine;
use App\Models\User; // Just in case, though customer views are public
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_home_page()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.index');
    }

    public function test_customer_can_search_medicines()
    {
        Medicine::factory()->create(['name' => 'UniqueMedicineName']);

        $response = $this->get(route('home', ['search' => 'UniqueMedicineName']));

        $response->assertStatus(200);
        $response->assertSee('UniqueMedicineName');
    }

    public function test_customer_can_view_medicine_detail()
    {
        $medicine = Medicine::factory()->create();
        
        // WARNING: The route is /medicine_detail/{slug} but controller uses find($id). 
        // We will try using the ID as the segment to match controller expectations.
        // If this test fails, it confirms the bug in the controller/route mismatch.
        $response = $this->get(route('show', ['slug' => $medicine->id]));

        $response->assertStatus(200);
        $response->assertViewIs('customer.show');
        $response->assertSee($medicine->name);
    }
}
