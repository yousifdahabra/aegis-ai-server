<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expert_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('extra_informations');
            $table->string('links');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();

        });

        Schema::create('expert_request_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('expert_request_id');
            $table->string('file_path');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('expert_requests');
        Schema::dropIfExists('expert_request_documents');

    }
};
