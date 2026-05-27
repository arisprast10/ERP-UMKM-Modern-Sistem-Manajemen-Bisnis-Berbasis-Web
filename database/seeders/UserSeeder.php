<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        $kasirRole = DB::table('roles')->where('slug', 'kasir')->first();
        $gudangRole = DB::table('roles')->where('slug', 'gudang')->first();

        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@erp.local',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasir Utama',
                'email' => 'kasir@erp.local',
                'password' => Hash::make('password'),
                'role_id' => $kasirRole->id,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staf Gudang',
                'email' => 'gudang@erp.local',
                'password' => Hash::make('password'),
                'role_id' => $gudangRole->id,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
