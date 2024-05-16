<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("Certification/Index", [
            'certifications' => auth()->user()->certifications
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
            'title' => 'required',
            'organisation' => 'required',
            'certification_date' => 'string|nullable',
            'expiration_date' => 'string|nullable',
            'additional_information' => 'string|nullable',
        ]);

        $validated['user_id'] = auth()->user()->id;

        $certification = Certification::create($validated);

        $certification->save();

        return redirect()->back()->with(['success' => "Certification Successfully Added!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certification $certification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certification $certification)
    {
        Gate::authorize('update', $certification);

        $validated = $request->validate([
            'title' => 'required',
            'organisation' => 'required',
            'certification_date' => 'string|nullable',
            'expiration_date' => 'string|nullable',
            'additional_information' => 'string|nullable',
        ]);

        $certification->update($validated);

        $certification->save();

        return redirect()->back()->with(['success' => "Certification Successfully Edited!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        Gate::authorize('delete', $certification);

        $certification->delete();

        return redirect()->back()->with(["success" => "Certification Deleted"]);
    }
}
