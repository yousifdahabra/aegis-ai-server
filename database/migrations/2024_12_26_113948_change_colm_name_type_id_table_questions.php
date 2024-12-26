<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('type_id', 'question_type_id');

        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('question_type_id', 'type_id');
        });
    }
};
