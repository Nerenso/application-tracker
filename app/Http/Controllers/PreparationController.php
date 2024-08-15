<?php

namespace App\Http\Controllers;

use App\Jobs\ProccessPreparationQuestionsGeneration;
use App\Models\JobListing;
use App\Models\Preparation;
use App\Traits\OpenAIAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PreparationController extends Controller
{
    use OpenAIAssistant;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $listing = JobListing::find($request->listingId);
        $user = $listing->user;

        Gate::authorize('view', $listing);
        $listing_text = json_encode($listing->structured_listing);
        $work_experiences = json_encode($user->workExperiences()->select('job_title', 'job_description', 'employment_period', 'company_name')->get());
        $skills = json_encode($user->skills()->select('title', 'description')->get());
        $education = json_encode($user->education()->select("degree_name", "institution_name", "location", "years_attended", "additional_information", "academic_progress")->get());
        $certifications = json_encode($user->certifications()->select('title', 'organisation', 'certification_date', 'expiration_date', 'additional_information')->get());

        $content = "<job-listing>{$listing_text}</job-listing> <work-experience>{$work_experiences}</work-experience> <skills>{$skills}</skills> <education>{$education}</education> <certifications>{$certifications}</certifications>";

        ProccessPreparationQuestionsGeneration::dispatch($listing, $content);

        return redirect()->back()->with(["success" => "Generation Process Started!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Preparation $preparation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preparation $preparation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preparation $preparation)
    {
        $listing = JobListing::find($request->listingId);

        Gate::authorize('view', $listing);
        $validated = $request->validate([
            'notes' => 'string|nullable',
        ]);

        $preparation->update([
            'notes' => $validated['notes']
        ]);

        $preparation->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preparation $preparation)
    {
        //
    }
}
