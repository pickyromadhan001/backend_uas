<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_lecturers', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('course_id')
                ->constrained('courses', 'course_id')
                ->onDelete('cascade');

            $table->foreignUlid('lecturer_id')
                ->constrained('lecturers', 'lecturer_id')
                ->onDelete('cascade');

            $table->string('role');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lecturers');
    }
};
