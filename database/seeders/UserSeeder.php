<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => env('ADMIN_USERNAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'phone_number' => env('ADMIN_PHONE'),
            'first_name' => 'admin',
            'last_name' => '1',
            'email_verified_at' => now(),
            'is_admin' => 1,
        ]);
    }
}
