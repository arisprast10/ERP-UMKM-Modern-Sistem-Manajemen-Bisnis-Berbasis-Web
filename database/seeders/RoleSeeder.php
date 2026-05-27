<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Kasir', 'slug' => 'kasir'],
            ['name' => 'Gudang', 'slug' => 'gudang']
        ];
        foreach($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
