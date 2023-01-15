<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ItemCategory;

class ItemCategory2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik'],
            ['name' => 'Pakaian'],
        ];

        foreach ($categories as $category) {
            ItemCategory::create($category);
        }
    }
}
