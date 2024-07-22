<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => 'shatha',
            "email" => 'shatha7nafel@gmail.com',
            "password" =>Hash::make("12345678"),
            "Depatrment_id" => 2,
            "role_id" => 2,
        ]);
    }

}
