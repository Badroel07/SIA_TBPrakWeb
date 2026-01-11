<?php

namespace Tests\Feature\Cashier;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    private $cashier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cashier = User::factory()->create(['role' => 'cashier']);
    }

    public function test_cashier_can_add_item_to_cart()
    {
        $medicine = Medicine::factory()->create(['stock' => 10]);

        $response = $this->actingAs($this->cashier)->post(route('cashier.transaction.cartAdd'), [
            'medicine_id' => $medicine->id,
            'quantity' => 2,
        ]);

        $response->assertSessionHas('success');
        
        $cart = Session::get('cart');
        $this->assertArrayHasKey($medicine->id, $cart);
        $this->assertEquals(2, $cart[$medicine->id]['quantity']);
    }

    public function test_cashier_can_clear_cart()
    {
        $medicine = Medicine::factory()->create();
        Session::put('cart', [
            $medicine->id => [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'price' => $medicine->price,
                'quantity' => 1,
                'subtotal' => $medicine->price,
            ]
        ]);

        $response = $this->actingAs($this->cashier)->post(route('cashier.transaction.cartClear'));

        $response->assertSessionHas('success');
        $this->assertEmpty(Session::get('cart'));
    }

    public function test_cashier_can_complete_transaction()
    {
        $medicine = Medicine::factory()->create(['stock' => 10, 'price' => 1000]);
        $cartItem = [
            'id' => $medicine->id,
            'name' => $medicine->name,
            'price' => $medicine->price,
            'quantity' => 2,
            'subtotal' => 2000,
        ];
        
        // Populate session
        Session::put('cart', [$medicine->id => $cartItem]);

        $formData = [
            'invoice_number' => 'INV-TEST-001',
            'total_amount' => 2000,
            // Controller might look for 'cart_data' input or session fallback.
            // We'll rely on session fallback as configured in controller.
            // 'cart_data' => json_encode([$medicine->id => $cartItem]), 
        ];

        $response = $this->actingAs($this->cashier)->post(route('cashier.transaction.processPayment'), $formData);

        $response->assertRedirect(route('cashier.transaction.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('transactions', [
            'invoice_number' => 'INV-TEST-001',
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('transaction_details', [
            'medicine_id' => $medicine->id,
            'quantity' => 2,
        ]);

        $medicine->refresh();
        $this->assertEquals(8, $medicine->stock); // 10 - 2
    }
}
