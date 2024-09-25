<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('patron_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double("fine")->nullable();
            $table->dateTime('returned')->nullable();
            $table->timestamps();

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('patron_id')
                ->references('patron_id')
                ->on('patrons')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_books');
    }
};
