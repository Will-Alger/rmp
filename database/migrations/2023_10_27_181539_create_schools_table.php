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
        if (!Schema::hasTable('schools')) {
            Schema::create('schools', function (Blueprint $table) {
                $table->string('id', 255)->primary();
                $table->integer('legacyId')->nullable();
                $table->string('name');
                $table->integer('numRatings');
                $table->string('state');
                $table->float('campusCondition');
                $table->float('campusLocation');
                $table->float('careerOpportunities');
                $table->float('clubAndEventActivities');
                $table->float('foodQuality');
                $table->float('internetSpeed');
                $table->float('libraryCondition');
                $table->float('schoolReputation');
                $table->float('schoolSafety');
                $table->float('schoolSatisfaction');
                $table->float('socialActivities');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
