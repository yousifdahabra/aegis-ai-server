<?php

namespace Database\Seeders;

use App\Models\TestState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestStatesSeeder extends Seeder
{
    public function run(): void
    {
        TestState::insert([
            ['title' => 'Pending'],
            ['title' => 'Progress'],
            ['title' => 'Done'],
        ]);

    }
}
