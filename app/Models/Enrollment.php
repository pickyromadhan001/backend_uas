<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Enrollment extends Model
{
    protected $primaryKey = 'enrollment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Hapus 'enrollment_id' dari fillable
    protected $fillable = [
        'student_id',
        'course_id',
        'grade',
        'attendance',
        'status',
    ];

    // Otomatis generate UUID saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->enrollment_id)) {
                $model->enrollment_id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
