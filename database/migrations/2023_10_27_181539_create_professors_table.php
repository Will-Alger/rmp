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
        Schema::create('professors', function (Blueprint $table) {
            $table->text('firstName');
            $table->string('lastName');
            $table->string('id')->primary();
            $table->string('typename');
            $table->string('schoolName');
            $table->string('schoolId');
            $table->integer('numRatings');
            $table->float('avgDifficulty');
            $table->float('avgRating');
            $table->string('department');
            $table->float('wouldTakeAgainPercent');
            $table->integer('legacyId');
            $table->timestamps();
            $table->foreign('schoolId')->references('id')->on('schools');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};
