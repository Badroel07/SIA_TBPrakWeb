<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Medicine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $cashier;
    protected $medicine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cashier = User::factory()->create([
            'role' => 'cashier',
        ]);
        
        $this->medicine = Medicine::factory()->create([
            'name' => 'Test Medicine',
            'price' => 10000,
            'stock' => 50,
        ]);
    }

    public function test_cashier_can_view_transaction_page()
    {
        $response = $this->actingAs($this->cashier)
                         ->get(route('cashier.transaction.index'));
        
        $response->assertStatus(200);
    }

    public function test_cashier_can_add_item_to_cart()
    {
        $response = $this->actingAs($this->cashier)
                         ->post(route('cashier.transaction.cartAdd'), [
                             'medicine_id' => $this->medicine->id,
                             'quantity' => 2,
                         ]);

        $response->assertRedirect(route('cashier.transaction.index'));
        $response->assertSessionHas('cart');
        
        $cart = Session::get('cart');
        $this->assertArrayHasKey($this->medicine->id, $cart);
        $this->assertEquals(2, $cart[$this->medicine->id]['quantity']);
    }

    public function test_cannot_add_more_than_available_stock()
    {
        // Try to add 100 items (stock is 50)
        $response = $this->actingAs($this->cashier)
                         ->post(route('cashier.transaction.cartAdd'), [
                             'medicine_id' => $this->medicine->id,
                             'quantity' => 100,
                         ]);

        $response->assertRedirect(route('cashier.transaction.index'));
        $response->assertSessionHas('error');
    }

    public function test_process_payment_deducts_stock_and_creates_transaction()
    {
        // 1. Manually set session cart
        $cartItem = [
            'id' => $this->medicine->id,
            'name' => $this->medicine->name,
            'price' => $this->medicine->price,
            'quantity' => 5,
            'subtotal' => 50000,
        ];
        Session::put('cart', [$this->medicine->id => $cartItem]);

        // 2. Post to process payment
        $response = $this->actingAs($this->cashier)
                         ->post(route('cashier.transaction.processPayment'), [
                             'invoice_number' => 'INV-TEST-001',
                             'total_amount' => 50000,
                             'cart_data' => json_encode([$cartItem]), // Emulate hidden input
                         ]);

        // 3. Assertions
        $response->assertRedirect(route('cashier.transaction.index'));
        $response->assertSessionHas('success');

        // Check Transaction Created
        $this->assertDatabaseHas('transactions', [
            'invoice_number' => 'INV-TEST-001',
            'total_amount' => 50000,
            'user_id' => $this->cashier->id,
        ]);

        // Check Stock Deducted (50 - 5 = 45)
        $this->assertDatabaseHas('medicines', [
            'id' => $this->medicine->id,
            'stock' => 45,
            'total_sold' => 5,
        ]);
        
        // Check Session Cart Cleared
        $this->assertFalse(Session::has('cart'));
    }
}
