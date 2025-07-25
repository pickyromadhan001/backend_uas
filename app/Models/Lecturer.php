<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lecturer extends Model
{
    protected $primaryKey = 'lecturer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'NIP',
        'department',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->lecturer_id)) {
                $model->lecturer_id = (string) Str::ulid();
            }
        });
    }

    // Seorang dosen bisa mengajar banyak courseLecturers
    public function courseLecturers()
    {
        return $this->hasMany(CourseLecturer::class, 'lecturer_id', 'lecturer_id');
    }
}
