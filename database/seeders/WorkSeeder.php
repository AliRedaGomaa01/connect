<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $works = [];
        foreach (['a', 'b', 'c', 'd'] as $key => $val) {
            $works[] = [
            'category' => "$val",
            'title' => "$val",
            'description' => "$val",
            'url' => "#$val",
            'user_id' => User::first()->id,
            ];
        }
        Work::insert(
            $works
        );
    }
}