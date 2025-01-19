<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTypesSeeder extends Seeder
{
    public function run(): void
    {
        QuestionType::insert([
            ['title' => 'input'],
            ['title' => 'radio'],
            ['title' => 'check'],
            ['title' => 'email'],
            ['title' => 'install'],
            ['title' => 'call'],
        ]);

    }
}
