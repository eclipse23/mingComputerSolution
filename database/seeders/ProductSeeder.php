<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($ctr = 0; $ctr < 100; $ctr++) {
            $category = rand(1,4);
            $price = rand(1,2000);
            $discount = rand(1,80);
            $stock = rand(1,3000);
            $imageUrl = $faker->imageUrl(640,480, null, false);

            $product = Product::create([
                'name' => $faker->catchPhrase,
                'brand' => $faker->company,
                'description' => $faker->text($maxNbChars = 200),
                'specification' => $faker->text($maxNbChars = 200),
                'category_id' => $category,
                'discount' => $discount,
                'price' => $price,
                'hot_deal' => $ctr % 2 == 0 ? 0 : 1,
                'new_arrival' => $ctr % 2 == 0 ? 1 : 0,
                'stock' => $stock
            ]);

            $product->addMediaFromUrl($imageUrl)->toMediaCollection('product-image-one');
            $product->addMediaFromUrl($imageUrl)->toMediaCollection('product-image-two');
            $product->addMediaFromUrl($imageUrl)->toMediaCollection('product-image-three');
            $product->addMediaFromUrl($imageUrl)->toMediaCollection('product-image-four');
            $product->addMediaFromUrl($imageUrl)->toMediaCollection('product-image-five');

            $this->command->line(($ctr+1)." of 100");
        }
    }
}
