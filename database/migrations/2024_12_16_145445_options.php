<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('options',function(Blueprint $table){
            $table->id();
            $table->integer('question_id');
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });
        Schema::create('user_answers',function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('question_id');
            $table->string('option_answer');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('user_answers');
    }
};
