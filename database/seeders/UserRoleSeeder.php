<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('user_roles')->insert(
        [
            'name' => 'admin',
        ],
        [
            'name' => 'expert',
        ],
        [
            'name' => 'user',
        ],
    );

    }
}
