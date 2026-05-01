<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Enrollment::with(['student', 'course'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'nullable|string|in:active,completed,dropped',
            'final_grade' => 'nullable|numeric|min:0|max:10',
        ]);

        $validated['enrolled_at'] = now();
        if (!isset($validated['status'])) {
            $validated['status'] = 'active';
        }

        $enrollment = Enrollment::create($validated);

        return response()->json($enrollment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Enrollment::with(['student', 'course'])->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'nullable|string|in:active,completed,dropped',
            'final_grade' => 'nullable|numeric|min:0|max:10',
        ]);

        $enrollment->update($validated);
        
        return response()->json($enrollment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Enrollment::destroy($id);
        return response()->json(null, 204);
    }
}
