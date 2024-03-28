<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('WorkExperience/Index', [
            "workExperiences" => WorkExperience::query()->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'string|required',
            'employment_period' => 'string|required',
            "job_description" => 'string|required',
            "company_name" => 'string'
        ]);

        $validated['user_id'] = auth()->user()->id;

        $createdWorkExperience = WorkExperience::create($validated);

        $createdWorkExperience->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkExperience $workExperience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkExperience $workExperience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $workExperience)
    {
        //
    }
}
