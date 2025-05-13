<?php

namespace App\Http\Controllers;

use App\Jobs\SummarizeListingJob;
use App\Models\Tag;
use Inertia\Inertia;
use App\Models\JobListing;
use App\Services\Timeline\TimelineActivityService;
use App\Services\URL\URLMetadataService;
use Illuminate\Http\Request;
use Stevebauman\Hypertext\Transformer;
use App\Traits\OpenAIAssistant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use LanguageDetection\Language;

class JobListingController extends Controller
{
  use OpenAIAssistant;

  private $urlService;
  private $transformer;
  private $language;
  private $timelineActivityService;

  public function __construct(URLMetadataService $urlService)
  {
    $this->urlService = $urlService;
    $this->transformer = new Transformer();
    $this->language = new Language();
    $this->timelineActivityService = new TimelineActivityService();
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $searchTerm = $request->input('search_term');

    $filters = $request->only(['location', 'salary_from', 'salary_to', 'selectedTags', 'show_bookmarked_only', 'selected_status']);

    if (isset($filters['show_bookmarked_only'])) {
      $filters['show_bookmarked_only'] = filter_var($filters['show_bookmarked_only'], FILTER_VALIDATE_BOOLEAN);
    }

    $listings = JobListing::userListingsWithTags($filters)->search($searchTerm)->filter($filters)
      ->paginate(6)->onEachSide(0)->withQueryString();

    return Inertia::render('JobListing/Index', [
      'listings' => $listings,
      "listings_paginator" => [
        "total" => $listings->total(),
        "listingsPerPage" => $listings->perPage(),
        "count" => $listings->count(),
        'currentPage' => $listings->currentPage()
      ],
      "filters" => $filters,
      "filteredResults" => empty(array_filter($filters)) ? false : true,
      "searchTerm" => $searchTerm,
      "tags" => Tag::where("user_id", auth()->user()->id)->orderBy('title')->get(),
      "verified" => $request->verified
    ]);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    if ($request->add_listing_mode == "manual") {
      $validated = $request->validate([
        'selectedTags' => 'array',
        'notes' => 'string|nullable',
        'salary_from' => 'integer|nullable',
        'salary_to' => 'integer|nullable',
        'location' => 'string|nullable',
        'contact_name' => 'string|nullable',
        'contact_phone' => 'string|nullable',
        'contact_email' => 'email|nullable',
        "pasted_listing_text" => "required",
        "job_link" => "required|url",
      ]);

      $urlMetaData = $this->urlService->getMetaData($validated["job_link"]);

      $detectedLang = $this->language->detect($validated["pasted_listing_text"])->__toString();


      $listing = array_merge($urlMetaData, [
        'user_id' => auth()->user()->id,
        'notes' => $validated['notes'],
        'salary_from' => $validated['salary_from'],
        'salary_to' => $validated['salary_to'],
        'contact_name' => $validated['contact_name'],
        'contact_phone' => $validated['contact_phone'],
        'contact_email' => $validated['contact_email'],
        'listing_plain_text' => $validated['pasted_listing_text'],
        'listing_language' => $detectedLang,
        'location' => $validated['location'],
        'status' => 'added'
      ]);

      // Save new job listing in database
      $createdListing = JobListing::create($listing);
      $createdListing->tags()->sync($validated['selectedTags']);
      $createdListing->save();

      // Dispatch open ai assistant to extract job details from extracted text
      SummarizeListingJob::dispatch($detectedLang, $validated["pasted_listing_text"], $createdListing);

      // Create timeline activities for added listing
      $this->createTimelineActivitiesForNewListing($createdListing, $validated['notes']);

      return redirect()->route('job-listing.index')->with(['success' => "Listing Successfully Added!"]);
    }

    if ($request->add_listing_mode == "automated") {

      $validated = $request->validate([
        "job_link" => "required|url",
        'selectedTags' => 'array',
        'notes' => 'string|nullable',
        'salary_from' => 'integer|nullable',
        'salary_to' => 'integer|nullable',
        'location' => 'string|nullable',
        'contact_name' => 'string|nullable',
        'contact_phone' => 'string|nullable',
        'contact_email' => 'email|nullable',
      ]);


      // Get added url page document and convert to plain text
      $urlMetaData = $this->urlService->getMetaData($validated["job_link"]);
      $htmlString = $this->urlService->getHTMLStringDocument($validated["job_link"]);
      $listing_plain_text = $this->transformer->keepNewLines()->toText($htmlString);

      if (!$urlMetaData["page_title"] || !$listing_plain_text) {
        return redirect()->route('job-listing.index')->with(['error' => "Oops, there was an error trying to add the listing using the 'AI Powered' mode. You can try again using the 'Manual' mode."]);
      }

      //Detect what language the plain text is written in
      $detectedLang = $this->language->detect($listing_plain_text)->__toString();

      //Assemble listing object to pass to the database
      $listing = array_merge($urlMetaData, [
        'user_id' => auth()->user()->id,
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
      ]);

      // Save new job listing in database
      $createdListing = JobListing::create($listing);
      $createdListing->tags()->sync($validated['selectedTags']);
      $createdListing->save();

      // Dispatch open ai assistant to extract job details from extracted text
      SummarizeListingJob::dispatch($detectedLang, $listing_plain_text, $createdListing);

      // Create timeline activities for added listing
      $this->createTimelineActivitiesForNewListing($createdListing, $validated['notes']);

      return redirect()->route('job-listing.index')->with(['success' => "Listing Successfully Added!"]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);

    return redirect()->route('listing-detail.timeline', $jobListing->id);
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
  public function destroy(Request $request, JobListing $jobListing)
  {

    Gate::authorize('delete', $jobListing);

    $jobListing->delete();

    if ($request->origin == "listing-detail") {
      return redirect()->route('job-listing.index')->with(['success' => "Listing Deleted!"]);
    } else {
      return redirect()->back()->with(["success" => "Listing Deleted"]);
    }
  }


  /**
   * Toggles the bookmarked status of a JobListing.
   *
   * If the is_bookmarked attribute is null, sets it to true.
   * Otherwise, toggles its value.
   *
   * @param JobListing $jobListing
   * @return \Illuminate\Http\RedirectResponse
   */
  public function toggleBookmarked(JobListing $jobListing)
  {
    Gate::authorize("update", $jobListing);

    if ($jobListing->is_bookmarked === null) {
      $jobListing->is_bookmarked = true;
    } else {
      $jobListing->is_bookmarked = !$jobListing->is_bookmarked;
    }

    $jobListing->save();

    return redirect()->back();
  }


  /**
   * Synchronizes the tags for a given JobListing with the selected tags from the request.
   *
   * Validates the request to ensure that 'selectedTags' is an array, then syncs the tags 
   * associated with the JobListing to match the provided 'selectedTags'. After synchronization, 
   * redirects back to the previous page.
   *
   * @param JobListing $jobListing The JobListing whose tags are being synchronized.
   * @param Request $request The HTTP request containing the selected tags data.
   * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page.
   */

  public function syncTags(JobListing $jobListing, Request $request)
  {
    $validated = $request->validate([
      "selectedTags" => 'array'
    ]);

    $jobListing->tags()->sync($validated['selectedTags']);

    return back();
  }

  public function updateStatus(JobListing $jobListing, Request $request)
  {
    Gate::authorize('update', $jobListing);

    $validated = $request->validate([
      'selectedStatus' => 'string',
      'selectedDate' => 'date',
    ]);

    $now = now()->setTimezone('Europe/Amsterdam');

    $statusDate = Carbon::parse($validated['selectedDate'])
      ->setTimezone('Europe/Amsterdam')
      ->setTime(
        $now->hour,
        $now->minute,
        $now->second
      );

    $jobListing->update([
      'status' => $validated['selectedStatus'],
      'status_updated_at' => $statusDate,
    ]);

    $jobListing->save();

    //Create timeline activity
    $this->timelineActivityService->createTimelineActivity($jobListing, [
      'title' => "Listing Status Updated",
      'activity_type' => 'status_updated',
      'description' => $validated['selectedStatus'],
      'activity_date' => $statusDate,
    ]);

    return back()->with(['success' => "Listing Status Updated!"]);
  }

  private function createTimelineActivitiesForNewListing(JobListing $jobListing, string $notes)
  {
    $now = now()->setTimezone('Europe/Amsterdam');

    //Create timeline activity for added listing
    $this->timelineActivityService->createTimelineActivity($jobListing, [
      'title' => "Listing Created",
      'activity_type' => 'listing_created',
      'activity_date' => $now,
    ]);

    //Create timeline activity for listing note
    if ($notes) {
      $this->timelineActivityService->createTimelineActivity($jobListing, [
        'title' => "Listing notes",
        'description' => $notes,
        'activity_type' => 'note_added',
        'activity_date' => $now->copy()->addMinute(),
      ]);
    }
  }
}
