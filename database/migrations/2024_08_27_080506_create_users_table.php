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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->string('last_name', 55);
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('email', 255);
            $table->string('contact_number');
            $table->string('username', 55);
            $table->string('password', 255);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
