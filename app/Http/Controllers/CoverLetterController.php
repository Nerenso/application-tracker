<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCoverLetterGenerationJob;
use App\Models\CoverLetter;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use function Spatie\LaravelPdf\Support\pdf;

class CoverLetterController extends Controller
{
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
        $contact_detail = json_encode($user->contactDetail()->select('first_name', 'last_name', 'email', 'phone')->first());
        $work_experiences = json_encode($request->selectedWorkExperiences);
        $skills = json_encode($request->selectedSkills);
        $education = json_encode($request->selectedEducation);

        $content = "<job-listing>{$listing_text}</job-listing>  <motivation>{$request->motivation}</motivation> <work-experience>{$work_experiences}</work-experience> <skills>{$skills}</skills> <education>{$education}</education> <meta>Candidate:{$contact_detail} Hiring Manager:{$listing->contact_name}</meta>";

        ProcessCoverLetterGenerationJob::dispatch($listing, $content, $request->motivation, generationType: "new");

        return redirect()->back()->with(["success" => "Generation Process Started!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoverLetter $coverLetter)
    {
        // dd($coverLetter);
        // dd($request->all());

        if ($request->updateType == 'update') {
            $validated = $request->validate([
                "coverLetterContent" => "required|string",
            ]);

            $coverLetter->update([
                "generated_letter" => $validated['coverLetterContent'],
            ]);

            $coverLetter->save();

            return redirect()->back()->with(["success" => "Successfully Updated Cover Letter!"]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoverLetter $coverLetter)
    {
        //
    }

    public function pdf()
    {
        return pdf()->view('pdf');
        // return view('pdf');
    }

    public function generatePDF()
    {
        return view('PDF.cover-letter');
    }
}
