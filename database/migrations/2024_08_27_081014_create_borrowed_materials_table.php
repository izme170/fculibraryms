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
        Schema::create('borrowed_materials', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->unsignedBigInteger('copy_id')->nullable();
            $table->unsignedBigInteger('patron_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('due_date');
            $table->double("fine")->nullable();
            $table->unsignedBigInteger('condition_before')->nullable();
            $table->unsignedBigInteger('condition_after')->nullable();
            $table->dateTime('returned')->nullable();
            $table->timestamps();

            $table->foreign('copy_id')
                ->references('copy_id')
                ->on('material_copies')
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

            $table->foreign('condition_before')
                ->references('condition_id')
                ->on('conditions')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('condition_after')
                ->references('condition_id')
                ->on('conditions')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_materials');
    }
};
