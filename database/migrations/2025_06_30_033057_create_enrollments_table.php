<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->ulid('enrollment_id')->primary();

            $table->foreignUlid('student_id')
                ->constrained('students', 'student_id')
                ->onDelete('cascade');

            $table->foreignUlid('course_id')
                ->constrained('courses', 'course_id')
                ->onDelete('cascade');

            $table->string('grade');
            $table->string('attendance');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
