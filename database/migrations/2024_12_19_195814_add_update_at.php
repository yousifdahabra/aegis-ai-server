<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('expert_request_documents', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('options', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('question_types', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('tests', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('test_states', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('user_answers', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('user_expert_requests', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
        
    }


    public function down(): void
    {
        Schema::table('expert_request_documents', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('question_types', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('test_states', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('user_expert_requests', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });

    }
};
