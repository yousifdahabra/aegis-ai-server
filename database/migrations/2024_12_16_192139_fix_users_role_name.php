<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_id', 'user_role_id');
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_role_id', 'role_id');
        });
    }
};
