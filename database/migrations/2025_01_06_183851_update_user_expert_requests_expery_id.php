<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('user_expert_requests', function (Blueprint $table) {
            $table->integer('expert_id')->nullable()->default('0')->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_expert_requests', function (Blueprint $table) {
            $table->integer('expert_id')->default(null)->change();
        });
    }
};
