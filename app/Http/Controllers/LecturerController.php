<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LecturerController extends Controller
{
    // Get all lecturers
    public function index()
    {
        return response()->json(Lecturer::all(), 200);
    }

    // Get single lecturer by id
    public function show($id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }
        return response()->json($lecturer, 200);
    }

    // Create new lecturer, lecturer_id auto-generated
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|unique:lecturers,NIP',
            'department' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
        ]);

        try {
            $lecturerId = (string) Str::ulid();

            $lecturer = Lecturer::create([
                'lecturer_id' => $lecturerId,
                'name' => $request->name,
                'NIP' => $request->NIP,
                'department' => $request->department,
                'email' => $request->email,
            ]);

            return response()->json($lecturer, 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update existing lecturer
    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'NIP' => 'sometimes|required|string|unique:lecturers,NIP,' . $id . ',lecturer_id',
            'department' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:lecturers,email,' . $id . ',lecturer_id',
        ]);

        try {
            $lecturer->update($request->all());
            return response()->json($lecturer, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete lecturer
    public function destroy($id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        try {
            $lecturer->delete();
            return response()->json(['message' => 'Lecturer deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
