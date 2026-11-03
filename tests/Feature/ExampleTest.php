<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_store_product(): void
    {
        $supplier = \App\Models\Supplier::firstOrCreate(
            ['email' => 'test@supplier.com'],
            ['supplier_name' => 'Supplier Uji', 'phone' => '08123456789']
        );

        $response = $this->post(route('product.store'), [
            'barcode_number' => 'BRG-TEST-' . time(),
            'product_name' => 'Produk Testing',
            'buy_price' => 10000,
            'sell_price' => 15000,
            'supplier_id' => $supplier->id,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('product.index'));
        $this->assertDatabaseHas('products', [
            'product_name' => 'Produk Testing',
            'supplier_id' => $supplier->id,
        ]);

        // Clean up
        \App\Models\Product::where('product_name', 'Produk Testing')->delete();
        \App\Models\Supplier::where('email', 'test@supplier.com')->delete();
    }
}
