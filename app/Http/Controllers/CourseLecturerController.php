<?php

namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;

class CourseLecturerController extends Controller
{
    public function index()
    {
        return response()->json(
            CourseLecturer::with(['course', 'lecturer'])->get(),
            200
        );
    }

    public function show($id)
    {
        $cl = CourseLecturer::with(['course', 'lecturer'])->find($id);
        if (!$cl) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($cl, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,course_id',
            'lecturer_id'  => 'required|exists:lecturers,lecturer_id',
            'role'         => 'required|string|max:100'
        ]);

        $cl = CourseLecturer::create($request->all());
        return response()->json($cl, 201);
    }

    public function update(Request $request, $id)
    {
        $cl = CourseLecturer::find($id);
        if (!$cl) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'course_id'    => 'sometimes|required|exists:courses,course_id',
            'lecturer_id'  => 'sometimes|required|exists:lecturers,lecturer_id',
            'role'         => 'sometimes|required|string|max:100'
        ]);

        $cl->update($request->all());
        return response()->json($cl, 200);
    }

    public function destroy($id)
    {
        $cl = CourseLecturer::find($id);
        if (!$cl) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $cl->delete();
        return response()->json(['message' => 'Data deleted'], 200);
    }
}
