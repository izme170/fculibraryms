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
        Schema::create('book_translators', function (Blueprint $table) {
            $table->id('book_translator_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('translator_id')->nullable();
            $table->timestamps();

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('translator_id')
                ->references('translator_id')
                ->on('translators')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_translators');
    }
};
