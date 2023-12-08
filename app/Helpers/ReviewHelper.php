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




    public function calculateQualityTrend(Collection $reviews)
    {
        $labels = [];
        $monthlyRatings = [];
        $runningTotal = 0;
        $counter = 0;


        // $reviews = $school->professorReviews()
        //     ->whereYear('date', $year)
        //     ->orderBy('date')
        //     ->get();
        // $computerScienceProfessors = $school->professors()
        //     ->where('department', 'Computer Science')

        //     ->get();

        // $professorIds = $computerScienceProfessors->pluck('id');

        // $reviews = Review::whereIn('teacherId', $professorIds)
        //     ->whereYear('date', $year)
        //     ->orderBy('date')
        //     ->get();

        $currentMonth = null;
        foreach ($reviews as $review) {
            $month = Carbon::parse($review->date)->format('Y-m');
            if ($review->qualityRating !== null) {
                $runningTotal += (float)$review->qualityRating;
                $counter++;
            }

            if ($currentMonth !== $month) {
                if ($currentMonth !== null) {
                    $monthlyRatings[] = $runningTotal / $counter;
                }
                $labels[] = $month;
                $currentMonth = $month;
            }
        }
        if ($currentMonth !== null && $counter > 0) {
            $monthlyRatings[] = $runningTotal / $counter;
        }
        return [$labels, $monthlyRatings];
    }
}
