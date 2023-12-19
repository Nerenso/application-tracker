<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Tag;
use Embed\Embed;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobListingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    return Inertia::render('JobListing/Index', [
      'listings' => JobListing::query()->where("user_id", auth()->user()->id)
        ->orderByDesc('created_at')
        ->with('tags', function (Builder $query) {
          $query->orderBy('title', 'ASC');
        })
        ->paginate(10),
      "tags" => Tag::where("user_id", auth()->user()->id)->orderBy('title')->get()
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
      "job_link" => "required|url",
      'selectedMultiple' => 'array',
      'notes' => 'string|nullable',
      'salary_from' => 'integer|nullable',
      'salary_to' => 'integer|nullable',
      'contact_name' => 'string|nullable',
      'contact_phone' => 'string|nullable',
      'contact_email' => 'email|nullable',
    ]);


    $embed = new Embed();

    $url = $embed->get($validated["job_link"]);

    $listing = [
      'user_id' => auth()->user()->id,
      'page_title' => $url->title,
      'company_name' => $url->providerName,
      'listing_url' => $url->url,
      'company_url' => $url->providerUrl,
      'img_url' => $url->icon,
      'notes' => $validated['notes'],
      'salary_from' => $validated['salary_from'],
      'salary_to' => $validated['salary_to'],
      'contact_name' => $validated['contact_name'],
      'contact_phone' => $validated['contact_phone'],
      'contact_email' => $validated['contact_email'],
    ];

    $createdListing = JobListing::create($listing);

    $createdListing->tags()->sync($validated['selectedMultiple']);

    $createdListing->save();

    return redirect(route('job-listing.index'));
  }

  /**
   * Display the specified resource.
   */
  public function show(JobListing $jobListing)
  {
    $jobListing->load('tags');

    return $jobListing;
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(JobListing $jobListing)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, JobListing $jobListing)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(JobListing $jobListing)
  {
    //
  }

  public function addTags(JobListing $jobListing, Request $request)
  {
    // dd($request->tags);

    // $jobListing->tags()->attach($request->tags);
    $tags = explode(",", $request->tags);

    dd($tags);

    return "attached";
  }
}
