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
        Schema::create('material_subjects', function (Blueprint $table) {
            $table->id('material_subject_id');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')
                ->references('material_id')
                ->on('materials')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('subject_id')
                ->references('subject_id')
                ->on('subjects')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_subjects');
    }
};
