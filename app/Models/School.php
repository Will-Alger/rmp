<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public function professors()
    {
        return $this->hasMany(Professor::class, 'schoolId', 'id');
    }

    public function professorReviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Professor::class,
            'schoolId',
            'teacherId',
            'id',
            'id'
        );
    }
    public static function findBy(string $name, string $state): ?School
    {
        return self::where('name', '=', "{$name}")
            ->where('state', $state)
            ->orderBy('numRatings', 'desc')
            ->first();
    }
}
