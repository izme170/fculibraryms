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
        Schema::create('material_translators', function (Blueprint $table) {
            $table->id('material_translator_id');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('translator_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')
                ->references('material_id')
                ->on('materials')
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
        Schema::dropIfExists('material_translators');
    }
};
