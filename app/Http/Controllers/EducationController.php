<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render("Education/Index", [
            'education' => auth()->user()->education
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
            "degree_name" => 'required|string',
            'institution_name' => 'required|string',
            'location' => 'nullable',
            'years_attended' => "required|string",
            'academic_progress' => 'nullable',
            "additional_information" => 'nullable'
        ]);

        $validated['user_id'] = auth()->user()->id;

        $createdEducation =  Education::create($validated);

        $createdEducation->save();

        return redirect()->back()->with(["success" => "Education Successfully Added!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        Gate::authorize('update', $education);

        $validated = $request->validate([
            "degree_name" => 'required|string',
            'institution_name' => 'required|string',
            'location' => 'nullable',
            'years_attended' => "required|string",
            'academic_progress' => 'nullable',
            "additional_information" => 'nullable'
        ]);

        $education->update($validated);

        $education->save();

        return redirect()->back()->with(["success" => "Education Successfully Updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        Gate::authorize('delete', $education);

        $education->delete();

        return redirect()->back()->with(["success" => "Education Successfully Deleted"]);
    }
}
