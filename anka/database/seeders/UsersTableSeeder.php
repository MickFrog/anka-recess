<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'email' => 'admin@material.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('participants')->insert([
            'name' => 'Ojok Emmanuel',
            'password' => 'secret',
            'product' => 'shoes',
            'dob' => now(),
            'points' => 12,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('participants')->insert([
            'name' => 'Ojok Emmanuel',
            'password' => 'secret',
            'product' => 'shoes',
            'dob' => now(),
            'points' => 34,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'name' => 'Shoes',
            'description' => 'Nice cool and cheap shoes',
            'quantity' => 12,
            'rate' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
            'participant_id' => 1
        ]);

        DB::table('bookings')->insert([
            'quantity' => 12,
            'created_at' => now(),
            'updated_at' => now(),
            'product_id' => 1,
            'user_id' => 1

        ]);
    }
}
