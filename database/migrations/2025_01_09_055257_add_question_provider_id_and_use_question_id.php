<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('question_provider_id')->default(1);
            $table->integer('use_question_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('question_provider_id');
            $table->dropColumn('use_question_id');
        });
    }
};
