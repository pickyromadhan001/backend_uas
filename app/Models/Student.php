<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'email', 'NIM', 'major', 'enrollment_year'];

    // Auto-generate ID saat membuat model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->student_id)) {
                $model->student_id = (string) Str::uuid(); // atau bisa pakai custom format
            }
        });
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
}

