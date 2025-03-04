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
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('title', 255);
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('edition')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('pages')->nullable();
            $table->string('size')->nullable();
            $table->string('includes')->nullable();
            $table->string('references')->nullable();
            $table->string('bibliography')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('material_image', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->foreign('type_id')
                ->references('type_id')
                ->on('material_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('publisher_id')
                ->references('publisher_id')
                ->on('publishers')
                ->onUpdate('cascade')
                ->onDelete('set null');

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
        Schema::dropIfExists('materials');
    }
};
