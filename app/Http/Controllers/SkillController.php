<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("Skill/Index", [
            "skills" => auth()->user()->skills
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => 'required',
            "description" => 'required'
        ]);

        $validated["user_id"] = auth()->user()->id;

        $skill = Skill::create($validated);

        $skill->save();

        return redirect()->back()->with(["success" => "Successfully Added Skill"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        Gate::authorize('update', $skill);

        $validated = $request->validate([
            "title" => 'required',
            "description" => 'required'
        ]);

        $skill->update($validated);

        $skill->save();

        return redirect()->back()->with(["success" => "Successfully Updated Skill!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        Gate::authorize('delete', $skill);

        $skill->delete();

        return redirect()->back()->with(["success" => "Skill Successfully Deleted!"]);
    }
}
