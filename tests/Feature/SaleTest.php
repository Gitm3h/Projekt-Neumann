<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Article;
use App\Models\User;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\StorageLocation;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_sale_stores_items_and_reduces_stock(): void
    {
        $cashier = User::factory()->create([
            'role' => 'kassenkraft',
            'must_change_password' => false,
        ]);

        $location = StorageLocation::create([
            'name' => 'A1'
        ]);

        $article = Article::create([
            'name' => 'Test Article',
            'type' => 'Dekoartikel',
            'price' => 100,
            'vat_rate' => 19,
            'min_stock' => 2,
        ]);

        Stock::create([
            'article_id' => $article->id,
            'storage_location_id' => $location->id,
            'quantity' => 10,
            'date' => now(),
        ]);

        $response = $this->actingAs($cashier)->post('/sales', [
            'payment_method' => 'Barzahlung',
            'items' => [
                ['article_id' => $article->id, 'quantity' => 3],
            ],
        ]);
        $response->assertRedirect(route('sales.index'));

        $this->assertDatabaseCount('sales',1);
        $this->assertDatabaseHas('sale_items',[
            'article_id' => $article->id,
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('stocks', [
            'article_id' => $article->id,
            'quantity' => 7,
        ]);

        $this->assertDatabaseCount('invoices',1);
    }

    public function test_invoice_payment_requires_a_customer(): void
    {
        $cashier = User::factory()->create([
            'role' => 'kassenkraft',
            'must_change_password' => false,
        ]);

        $article = Article::create([
            'name' => 'Test Article',
            'type' => 'Dekoartikel',
            'price' => 100,
            'vat_rate' => 19,
            'min_stock' => 2,
        ]);

        $response = $this->actingAs($cashier)->post('/sales', [
            'payment_method' => 'Rechnung',
            'items' => [
                ['article_id' => $article->id, 'quantity' => 1],
            ],
        ]);

        $response->assertSessionHasErrors('customer_id');
    }
}
