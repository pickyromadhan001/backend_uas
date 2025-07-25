<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'code', 'credits', 'semester'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->course_id)) {
                $model->course_id = (string) Str::ulid();
            }
        });
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function courseLecturers()
    {
        return $this->hasMany(CourseLecturer::class, 'course_id', 'course_id');
    }
}
