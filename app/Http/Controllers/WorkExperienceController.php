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
            "workExperiences" => WorkExperience::query()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get()
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
            'job_title' => 'required',
            'employment_period' => 'nullable',
            "job_description" => 'required',
            "company_name" => 'nullable'
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
        $validated = $request->validate([
            'job_title' => 'required',
            'employment_period' => 'nullable',
            "job_description" => 'required',
            "company_name" => 'nullable'
        ]);

        $workExperience->update($validated);

        return redirect()->back()->with(['success' => "Work Experience Updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $workExperience)
    {
        $workExperience->delete();

        return redirect()->back()->with(["success" => "Work Experience Deleted!"]);
    }
}
