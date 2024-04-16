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
            'user_name' => env('ADMIN_USERNAME') ?? 'test user name',
            'email' => env('ADMIN_EMAIL') ?? 'test@test.com',
            'password' => Hash::make(env('ADMIN_PASSWORD') ?? 'password'),
            'phone_number' => env('ADMIN_PHONE') ?? '0123456789',
            'first_name' => 'admin',
            'last_name' => '1',
            'email_verified_at' => now(),
            'is_admin' => 1,
        ]);
    }
}
