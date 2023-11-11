<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function school(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(School::class, 'schoolId');
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class, 'teacherId');
    }

    public function avgQualityRating()
    {
        return round($this->reviews()->avg('qualityRating'), 1);
    }

    public function avgDifficultyRating()
    {
        return round($this->reviews()->avg('difficultyRating'), 1);
    }

    public function avgWouldTakeAgain()
    {
        return round($this->reviews()->avg('wouldTakeAgain') * 100, 0);
    }
}
