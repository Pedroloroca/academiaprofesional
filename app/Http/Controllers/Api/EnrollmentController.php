<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
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
    public function store(StoreEnrollmentRequest $request)
    {
        $validated = $request->validated();

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
    public function update(UpdateEnrollmentRequest $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        $validated = $request->validated();

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
