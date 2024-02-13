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
        \App\Models\User::insert(
            [
            'name' => 'a',
            'email' => 'a@a.a',
            ],
            [
            'name' => 'b',
            'email' => 'b@b.b',
            ],
            [
            'name' => 'c',
            'email' => 'c@c.c',
            ],
            [
            'name' => 'd',
            'email' => 'd@d.d',
            ],
        );
    }
}