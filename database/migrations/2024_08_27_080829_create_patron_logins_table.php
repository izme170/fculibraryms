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
        Schema::create('patron_logins', function (Blueprint $table) {
            $table->id('login_id');
            $table->unsignedBigInteger('patron_id')->nullable();
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->unsignedBigInteger('marketer_id')->nullable();
            $table->timestamps();

            $table->foreign('patron_id')
                ->references('patron_id')
                ->on('patrons')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('purpose_id')
                ->references('purpose_id')
                ->on('purposes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('marketer_id')
                ->references('marketer_id')
                ->on('marketers')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patron_logins');
    }
};
