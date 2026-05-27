<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = DB::table('categories')->where('slug', 'makanan')->first();
        $minuman = DB::table('categories')->where('slug', 'minuman')->first();

        DB::table('products')->insert([
            [
                'barcode' => 'PRD0001',
                'name' => 'Indomie Goreng',
                'category_id' => $makanan->id,
                'buy_price' => 2500,
                'sell_price' => 3500,
                'stock' => 100,
                'min_stock' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => 'PRD0002',
                'name' => 'Aqua Botol 600ml',
                'category_id' => $minuman->id,
                'buy_price' => 2000,
                'sell_price' => 3500,
                'stock' => 50,
                'min_stock' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
