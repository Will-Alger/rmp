<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReviewHelper
{
    public function getReviews(string $schoolId, ?int $year = null, ?string $department = null): Collection
    {
        $school = School::with(['professors' => function ($query) use ($department) {
            if ($department) {
                $query->where('department', $department);
            }
        }])->where('id', $schoolId)
            ->firstOrFail();

        $professorIds = $school->professors->pluck('id');
        $reviews = Review::whereIn('teacherId', $professorIds);
        if ($year) {
            $reviews->whereYear('date', $year);
        }
        return $reviews->orderBy('date')
            ->get();
    }

    public function calculateQualityTrend(Collection $reviews, array $labels)
    {
        $monthlyRatings = [];
        $runningTotal = 0;
        $counter = 0;
        $previousAverage = 0;

        foreach ($labels as $label) {
            $hasReviews = false;

            foreach ($reviews as $review) {
                $reviewMonth = Carbon::parse($review->date)->format('m');
                if ($reviewMonth === $label && $review->qualityRating !== null) {
                    $runningTotal += (float)$review->qualityRating;
                    $counter++;
                    $hasReviews = true;
                }
            }

            if ($hasReviews) {
                $average = number_format($runningTotal / $counter, 2);
                $monthlyRatings[] = $average;
                $previousAverage = $average;
            } else {
                $monthlyRatings[] = $previousAverage;
            }
        }
        return $monthlyRatings;
    }
}
