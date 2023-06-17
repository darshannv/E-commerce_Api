<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_create_a_new_Product()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 9.99,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 9.99,
        ]);
    }



    public function test_to_get_all_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_to_store_a_new_Product()
    {
        $data = [
            'name' => 'New Product',
            'description' => 'This is a New product',
            'price' => 88.22,
            'variants' => [
                [
                    'name' => 'Variant 1',
                    'sku' => 'SKU001',
                    'additional_cost' => 2.50,
                    'stock_count' => 10,
                ],
            ],
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'New Product',
                'description' => 'This is a New product',
                'price' => 88.22,
            ]);
    }

    // Write similar tests for other endpoints (show, update, delete)

    public function test_to_Search_a_product_with_names()
    {
        Product::factory()->create([
            'name' => 'Test Product 1',
            'description' => 'This is a test product',
            'price' => 9.99,
        ]);

        Product::factory()->create([
            'name' => 'Product 2',
            'description' => 'This is another test product',
            'price' => 19.99,
        ]);

        $response = $this->get('/api/products/search/{query}');

        $response->assertStatus(200);
    }
}
