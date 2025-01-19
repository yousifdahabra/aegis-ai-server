<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('expert_requests', function (Blueprint $table) {
            $table->integer('state')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('expert_requests', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
};
