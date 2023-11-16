<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->text('id')->primary();
                $table->text('typename')->nullable();
                $table->text('attendanceMandatory')->nullable();
                $table->integer('clarityRating')->nullable();
                $table->text('class')->nullable();
                $table->text('comment')->nullable();
                $table->boolean('createdByUser')->nullable();
                $table->text('date')->nullable();
                $table->integer('difficultyRating')->nullable();
                $table->text('flagStatus')->nullable();
                $table->text('grade')->nullable();
                $table->integer('helpfulRating')->nullable();
                $table->boolean('isForCredit')->nullable();
                $table->boolean('isForOnlineClass')->nullable();
                $table->integer('legacyId')->nullable();
                $table->text('ratingTags')->nullable();
                $table->text('teacherNote')->nullable();
                $table->integer('textbookUse')->nullable();
                $table->integer('thumbsDownTotal');
                $table->integer('thumbsUpTotal')->nullable();
                $table->integer('wouldTakeAgain')->nullable();
                $table->text('teacherId')->nullable();
                $table->float('qualityRating')->nullable();
                // Include created_at and updated_at timestamps if they
                $table->foreign('teacherId')->references('id')->on('professors');
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
