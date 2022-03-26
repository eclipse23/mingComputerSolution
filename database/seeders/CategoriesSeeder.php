<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Computer'
        ]);

        Category::create([
            'name' => 'Gadget'
        ]);

        Category::create([
            'name' => 'Accessories'
        ]);

        Category::create([
            'name' => 'Computer Parts'
        ]);
        
    }
}
