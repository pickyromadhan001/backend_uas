<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return response()->json(
            Enrollment::with(['student', 'course'])->get(),
            200
        );
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }
        return response()->json($enrollment, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,student_id',
            'course_id'   => 'required|exists:courses,course_id',
            'grade'       => 'nullable|string|max:5',
            'attendance'  => 'nullable|integer|min:0|max:100',
            'status'      => 'required|string|max:20',
        ]);

        $enrollment = Enrollment::create($request->all());

        return response()->json($enrollment, 201);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $request->validate([
            'student_id'  => 'sometimes|required|exists:students,student_id',
            'course_id'   => 'sometimes|required|exists:courses,course_id',
            'grade'       => 'nullable|string|max:5',
            'attendance'  => 'nullable|integer|min:0|max:100',
            'status'      => 'sometimes|required|string|max:20',
        ]);

        $enrollment->update($request->all());

        return response()->json($enrollment, 200);
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted'], 200);
    }
}
