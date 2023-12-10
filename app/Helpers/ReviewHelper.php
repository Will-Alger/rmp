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




    // public function calculateQualityTrend(Collection $reviews)
    // {
    //     $labels = [];
    //     $monthlyRatings = [];
    //     $runningTotal = 0;
    //     $counter = 0;

    //     $currentMonth = null;
    //     foreach ($reviews as $review) {
    //         $month = Carbon::parse($review->date)->format('Y-m');
    //         if ($review->qualityRating !== null) {
    //             $runningTotal += (float)$review->qualityRating;
    //             $counter++;
    //         }

    //         if ($currentMonth !== $month) {
    //             if ($currentMonth !== null) {
    //                 $monthlyRatings[] = number_format($runningTotal / $counter, 2);
    //             }
    //             $labels[] = $month;
    //             $currentMonth = $month;
    //         }
    //     }
    //     if ($currentMonth !== null && $counter > 0) {
    //         $monthlyRatings[] = number_format($runningTotal / $counter, 2);
    //     }
    //     $currentMonthNumber = Carbon::now()->month;
    //     while (count($monthlyRatings) < $currentMonthNumber) {
    //         $monthlyRatings[] = end($monthlyRatings) ?: 0;
    //     }
    //     return $monthlyRatings;
    // }
    public function calculateQualityTrend(Collection $reviews, array $labels)
    {
        $monthlyRatings = [];
        $runningTotal = 0;
        $counter = 0;
        $previousAverage = 0; // Initialize previous month's average

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
                $previousAverage = $average; // Update previous month's average
            } else {
                $monthlyRatings[] = $previousAverage; // Use previous average if no reviews
            }
        }

        return $monthlyRatings;
    }
}
  // return [$labels, $monthlyRatings];
