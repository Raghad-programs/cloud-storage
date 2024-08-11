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
            "first_name" => 'shatha',
            "last_name" => 'nafel',
            "email" => 'shatha7nafel@gmail.com',
            "password" =>Hash::make("12345678"),
            "phone_number" => "055897180",
            "Depatrment_id" => 2,
            "role_id" => 2,
        ]);
    }

}
