<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Get all courses
    public function index()
    {
        return response()->json(Course::all(), 200);
    }

    // Get single course
    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        return response()->json($course);
    }

    // Store course (tanpa input course_id)
    public function store(Request $request)
    {
        $request->validate([
            // 'course_id' => 'required|unique:courses', // HAPUS ini
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20',
            'credits' => 'required|integer',
            'semester' => 'required|integer',
        ]);

        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    // Update course
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'code' => 'sometimes|required|string|max:20',
            'credits' => 'sometimes|required|integer',
            'semester' => 'sometimes|required|integer',
        ]);

        $course->update($request->all());
        return response()->json($course);
    }

    // Delete course
    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted']);
    }
}
