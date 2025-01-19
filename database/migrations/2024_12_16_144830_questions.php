<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id');
            $table->integer('type_id');
            $table->integer('previous_question_id')->default(0);
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });
        Schema::create('question_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_types');
    }
};
