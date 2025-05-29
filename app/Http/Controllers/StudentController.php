<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // Get a single student
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student);
    }

    // Create new student (tanpa input student_id)
    public function store(Request $request)
    {
        $request->validate([
            // 'student_id' => 'required|string|unique:students', // Hapus baris ini
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'NIM' => 'required|string|max:50',
            'major' => 'required|string',
            'enrollment_year' => 'required|date'
        ]);

        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    // Update existing student
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:50',
            'NIM' => 'sometimes|required|string|max:50',
            'major' => 'sometimes|required|string',
            'enrollment_year' => 'sometimes|required|date'
        ]);

        $student->update($request->all());
        return response()->json($student);
    }

    // Delete a student
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted']);
    }
}
