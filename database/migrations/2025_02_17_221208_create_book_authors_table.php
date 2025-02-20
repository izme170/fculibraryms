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
        Schema::create('book_authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('author_id')
                ->references('author_id')
                ->on('authors')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_authors');
    }
};
