<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('expert_id')->default(0);
            $table->integer('state_id')->default(1);
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });
        Schema::create('test_states', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
        Schema::dropIfExists('test_states');

    }
};
