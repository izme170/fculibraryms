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
        Schema::create('patrons', function (Blueprint $table) {
            $table->id('patron_id');
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->string('last_name', 55);
            $table->string('email', 255);
            $table->string('contact_number', 55);
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('address', 255);
            $table->string('school_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->integer('year');
            $table->unsignedBigInteger('adviser_id')->nullable();
            $table->string('library_id');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->foreign('type_id')
                ->references('type_id')
                ->on('patron_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('adviser_id')
                ->references('adviser_id')
                ->on('advisers')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrons');
    }
};
