<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void{
        Schema::create('user_expert_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('expert_id');
            $table->string('about_user');
            $table->string('user_note');
            $table->string('links');

        });
    }


    public function down(): void{

    }
};
