<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertToStructuredListing;
use App\Jobs\SummarizeListingJob;
use Embed\Embed;
use App\Models\Tag;
use Inertia\Inertia;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Stevebauman\Hypertext\Transformer;
use Illuminate\Contracts\Database\Query\Builder;
use App\Traits\OpenAIAssistant;
use Illuminate\Support\Facades\Gate;
use LanguageDetection\Language;

class JobListingController extends Controller
{
  use OpenAIAssistant;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    $listings = JobListing::query()
      ->where("user_id", auth()->user()->id)
      ->orderByDesc('created_at')
      ->with('tags', function (Builder $query) {
        $query->orderBy('title', 'ASC');
      })
      ->paginate(6)->onEachSide(0);


    return Inertia::render('JobListing/Index', [
      'listings' => $listings,
      "listings_paginator" => [
        "total" => $listings->total(),
        "listingsPerPage" => $listings->perPage(),
        "count" => $listings->count(),
        'currentPage' => $listings->currentPage()
      ],
      "tags" => Tag::where("user_id", auth()->user()->id)->orderBy('title')->get()
    ]);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      "job_link" => "required|url",
      'selectedMultiple' => 'array',
      'notes' => 'string|nullable',
      'salary_from' => 'integer|nullable',
      'salary_to' => 'integer|nullable',
      'location' => 'string|nullable',
      'contact_name' => 'string|nullable',
      'contact_phone' => 'string|nullable',
      'contact_email' => 'email|nullable',
    ]);

    $transformer = new Transformer();
    $embed = new Embed();
    $ld = new Language();

    // Get added url page document and convert to plain text
    $url = $embed->get($validated["job_link"]);
    $document = $url->getDocument();
    $html = (string) $document;
    $listing_plain_text = $transformer->keepNewLines()->toText($html);

    //Detect what language the plain text is written in
    $detectedLang = $ld->detect($listing_plain_text)->__toString();

    //Assemble listing object to pass to the database
    $listing = [
      'user_id' => auth()->user()->id,
      'page_title' => $url->title,
      'company_name' => $url->providerName,
      'listing_url' => $url->url,
      'company_url' => $url->providerUrl,
      'img_url' => $url->icon ?? $url->favicon,
      'notes' => $validated['notes'],
      'salary_from' => $validated['salary_from'],
      'salary_to' => $validated['salary_to'],
      'contact_name' => $validated['contact_name'],
      'contact_phone' => $validated['contact_phone'],
      'contact_email' => $validated['contact_email'],
      'listing_plain_text' => $listing_plain_text,
      'listing_language' => $detectedLang,
      'location' => $validated['location'],
      'status' => 'added'
    ];

    // Save new job listing in database
    $createdListing = JobListing::create($listing);
    $createdListing->tags()->sync($validated['selectedMultiple']);
    $createdListing->save();

    // Dispatch open ai assistant to extract job details from extracted text
    SummarizeListingJob::dispatch($detectedLang, $listing_plain_text, $createdListing);

    return redirect()->back()->with(['success' => "Listing Successfully Added!"]);
  }

  /**
   * Display the specified resource.
   */
  public function show(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);

    $listing = JobListing::query()->where('id', $jobListing->id)->with('tags', function (Builder $query) {
      $query->orderBy('title', "ASC");
    })->get()->first();

    return Inertia::render('JobListing/Show', [
      "listing" => $listing,
      "tags" => Tag::where("user_id", auth()->user()->id)->orderBy('title')->get()
    ]);
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, JobListing $jobListing)
  {
    Gate::authorize('update', $jobListing);

    $validated = $request->validate([
      'location' => 'string|nullable',
      'notes' => 'string|nullable',
      'salary_from' => 'integer|nullable',
      'salary_to' => 'integer|nullable',
      'contact_name' => 'string|nullable',
      'contact_phone' => 'string|nullable',
      'contact_email' => 'email|nullable',
    ]);

    $jobListing->update($validated);

    $jobListing->save();

    return redirect()->back()->with(['success' => "Listing Updated!"]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(JobListing $jobListing)
  {
    $jobListing->delete();

    return redirect()->back()->with(["success" => "Listing Deleted"]);
  }

  public function addTags(JobListing $jobListing, Request $request)
  {
    // dd($request->tags);

    // $jobListing->tags()->attach($request->tags);
    $tags = explode(",", $request->tags);

    dd($tags);

    return "attached";
  }

  public function syncTags(JobListing $jobListing, Request $request)
  {
    $validated = $request->validate([
      "selectedTags" => 'array'
    ]);

    $jobListing->tags()->sync($validated['selectedTags']);

    return back();
  }


  public function testCall()
  {
    // $this->testFunctionCall();

    $listings = JobListing::query()
      ->where("listing_plain_text", "!=", null)
      // ->where("structured_listing", "=", null)
      ->orderBy('created_at', 'desc')
      ->skip(0)
      ->limit(6)
      ->get();

    // dd($listings[0]);

    ConvertToStructuredListing::dispatch($listings[0]);

    // $this->testFunctionCall($listings[0]->listing_plain_text);
  }
}
