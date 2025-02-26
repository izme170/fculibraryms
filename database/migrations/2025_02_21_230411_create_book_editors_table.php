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
        Schema::create('book_editors', function (Blueprint $table) {
            $table->id('book_editor_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->timestamps();

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('editor_id')
                ->references('editor_id')
                ->on('editors')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_editors');
    }
};
