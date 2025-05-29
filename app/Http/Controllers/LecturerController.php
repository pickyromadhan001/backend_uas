<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // untuk generate ID

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

        // Generate unique lecturer_id (misal UUID)
        $lecturerId = (string) Str::uuid();

        $lecturer = Lecturer::create([
            'lecturer_id' => $lecturerId,
            'name' => $request->name,
            'NIP' => $request->NIP,
            'department' => $request->department,
            'email' => $request->email,
        ]);

        return response()->json($lecturer, 201);
    }

    // Update existing lecturer
    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        // Validasi unik email dan NIP kecuali pada record yang sedang diupdate
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'NIP' => 'sometimes|required|string|unique:lecturers,NIP,' . $id . ',lecturer_id',
            'department' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:lecturers,email,' . $id . ',lecturer_id',
        ]);

        $lecturer->update($request->all());

        return response()->json($lecturer, 200);
    }

    // Delete lecturer
    public function destroy($id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $lecturer->delete();

        return response()->json(['message' => 'Lecturer deleted'], 200);
    }
}
