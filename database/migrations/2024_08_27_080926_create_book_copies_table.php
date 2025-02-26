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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id('copy_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->string('copy_number')->unique();
            $table->string('rfid')->unique();
            $table->string('accession_number')->nullable();
            $table->string('call_number')->nullable();
            $table->string('price')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('fund_id')->nullable();
            $table->date('date_acquired')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('vendor_id')
                ->references('vendor_id')
                ->on('vendors')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('fund_id')
                ->references('fund_id')
                ->on('funding_sources')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
