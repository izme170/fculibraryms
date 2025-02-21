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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('book_rfid');
            $table->string('accession_number')->nullable();
            $table->string('call_number')->nullable();
            $table->string('isbn')->nullable();
            $table->string('title', 255);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('book_image', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
