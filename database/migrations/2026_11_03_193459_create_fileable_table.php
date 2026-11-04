<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fileable', function (Blueprint $table) {
            $table->foreignId('file_id')
                ->constrained('file');
            $table->enum('relation_with', ['user', 'article', 'reply']);
            $table->integer('relation_id');
            $table->string('role', 32)
                ->default('attachment');
            $table->timestamps();

            $table->unique(['file_id', 'relation_with', 'relation_id']);
            $table->index(['relation_with', 'relation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fileable');
    }
};
