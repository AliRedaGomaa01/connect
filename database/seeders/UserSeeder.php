<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];
        foreach (['a', 'b', 'c', 'd'] as $key => $val) {
            $users[] = [
            'name' => "$val",
            'email' => "$val@$val.$val",
            'password' => bcrypt("$val")
            ];
        }
        \App\Models\User::insert(
            $users
        );
    }
}