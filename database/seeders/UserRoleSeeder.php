<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{

    public function run(): void
    {
        UserRole::insert([
            ['title' => 'admin'],
            ['title' => 'expert'],
            ['title' => 'user'],
        ]);
    }
}
