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
            $table->string('title', 255);
            $table->string('isbn')->nullable();
            $table->string('publisher', 255)->nullable();
            $table->string('publication_date')->nullable();
            $table->string('edition')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('pages')->nullable();
            $table->string('references')->nullable();
            $table->string('bibliography')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('book_image', 255)->nullable();
            $table->string('description', 255)->nullable();
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
