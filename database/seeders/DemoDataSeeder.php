<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\StorageLocation;
use App\Models\Stock;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = collect(['Regal A1', 'Regal A2', 'Halle B', 'Lager C'])
            ->map(fn ($name) => StorageLocation::create (['name' => $name]));

        $articles = [
            ['name' => 'Beistelltisch Oslo', 'type' => 'Kleinmöbel', 'size' => '40x40x45cm', 'colour' => 'Eiche', 'weight' => 6.5, 'model_year' => 2025, 'price' => 79.90, 'min_stock'=> 5, 'quantity' => 12],
            ['name' => 'Sideboard Bergen', 'type' => 'Kleinmöbel', 'size' => '120x40x75cm', 'colour' => 'Weiß', 'weight' => 32.0, 'model_year' => 2025, 'price' => 249.90, 'min_stock'=> 3, 'quantity' => 1],
            ['name' => 'Hocker Malmö', 'type' => 'Kleinmöbel', 'size' => '35x35x42cm', 'colour' => 'Grau', 'weight' => 4.2, 'model_year' => 2024, 'price' => 34.50, 'min_stock'=> 8, 'quantity' => 20],
            ['name' => 'Wanduhr Rund', 'type' => 'Deko', 'size' => 'Ø30cm', 'colour' => 'Schwarz', 'weight' => 0.8, 'model_year' => 2025, 'price' => 19.90, 'min_stock'=> 15, 'quantity' => 6],
            ['name' => 'Vase Keramik', 'type' => 'Deko', 'size' => '25cm', 'colour' => 'Terrakotta', 'weight' => 1.2, 'model_year' => 2025, 'price' => 24.90, 'min_stock'=> 10, 'quantity' => 18],
            ['name' => 'Bilderrahmen Set', 'type' => 'Deko', 'size' => '3-teilig', 'colour' => 'Natur', 'weight' => 1.5, 'model_year' => 2024, 'price' => 29.90, 'min_stock'=> 12, 'quantity' => 0],
            ['name' => 'Schreibtischlampe LED', 'type' => 'Beleuchtung', 'size' => '45cm', 'colour' => 'Schwarz', 'weight' => 1.1, 'model_year' => 2025, 'price' => 39.90, 'min_stock'=> 10, 'quantity' => 25],
            ['name' => 'Lightbox A4', 'type' => 'Beleuchtung', 'size' => 'A4', 'colour' => 'Weiß', 'weight' => 0.9, 'model_year' => 2025, 'price' => 22.90, 'min_stock'=> 12, 'quantity' => 9],
            ['name' => 'Stehlampe Kupfer', 'type' => 'Beleuchtung', 'size' => '150cm', 'colour' => 'Kupfer', 'weight' => 3.4, 'model_year' => 2024, 'price' => 89.90,  'min_stock'=> 5, 'quantity' => 15],
        ];

        foreach ($articles as $a) {
            $quantity = $a['quantity'];
            unset($a['quantity']);

            $article = Article::create($a);

            Stock::create([
                'article_id' => $article->id,
                'storage_location_id' => $locations->random()->id,
                'quantity' => $quantity,
                'date' => now()->subDays(rand(1, 60)),
            ]);
        }
    }
}
