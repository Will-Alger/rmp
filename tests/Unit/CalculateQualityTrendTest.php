<?php

namespace Tests\Unit;

use App\Charts\SchoolTrend;
use App\Models\School;
use App\Models\Review;
use Carbon\Carbon;
use Tests\TestCase;

class CalculateQualityTrendTest extends TestCase
{
    public function testLastAverage_MatchesOverallAverage()
    {
        $school = new School();
        $reviews = [];

        $reviews[] = new Review(['date' => Carbon::parse('2023-10-01'), 'qualityRating' => 4]);
        $reviews[] = new Review(['date' => Carbon::parse('2023-10-15'), 'qualityRating' => 3]);
        $reviews[] = new Review(['date' => Carbon::parse('2023-11-05'), 'qualityRating' => 5]);

        $school->professorReviews = collect($reviews);
        $trendData = app(SchoolTrend::class)->calculateQualityTrend($school, 2023);
        $lastAverage = array_pop($trendData[1]);
        $overallAverage = $school->professorReviews->avg('qualityRating');
        $this->assertEquals($lastAverage, $overallAverage);
    }
}
