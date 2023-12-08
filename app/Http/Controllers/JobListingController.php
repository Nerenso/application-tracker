<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Embed\Embed;
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
      'listings' => JobListing::where("user_id", auth()->user()->id)->get()
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
      "job_link" => "required|url"
    ]);

    // dd($validated["job_link"]);
    // dd(auth()->user()->id);


    $embed = new Embed();

    $url = $embed->get($validated["job_link"]);

    $listing = [
      'user_id' => auth()->user()->id,
      'page_title' => $url->title,
      'company_name' => $url->providerName,
      'listing_url' => $url->url,
      'company_url' => $url->providerUrl,
      'img_url' => $url->image
    ];

    JobListing::create($listing);

    return redirect(route('job-listing.index'));
  }

  /**
   * Display the specified resource.
   */
  public function show(JobListing $jobListing)
  {
    //
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
}
