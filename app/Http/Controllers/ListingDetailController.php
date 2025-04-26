<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use App\Models\JobListing;
use App\Models\Preparation;
use App\Models\Tag;
use App\Models\User;
use App\Traits\OpenAIAssistant;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ListingDetailController extends Controller
{
  use OpenAIAssistant;

  protected $listing;
  protected $tags;

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      // Use route model binding to get the job listing
      $jobListing = $request->route('job_listing');

      // Get job listing with Tags
      $this->listing = JobListing::query()->where('id', $jobListing->id)
        ->with('tags', function (Builder $query) {
          $query->orderBy('title', "ASC");
        })->first();

      // Get all the user's tags
      $this->tags = Tag::where("user_id", auth()->user()->id)
        ->orderBy('title')->get();

      return $next($request);
    });
  }

  public function overview(Request $request, JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);
    return Inertia::render('JobListing/ListingDetail/Overview', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }

  public function preparation(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);
    $preparation = Preparation::where('job_listing_id', $jobListing->id)->first();
    return Inertia::render('JobListing/ListingDetail/Preparation', [
      "listing" => $this->listing,
      "tags" => $this->tags,
      "preparation" => $preparation
    ]);
  }

  public function coverLetter(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);

    $user = $jobListing->user;

    $workexperiences = $user->workExperiences()->select('job_title', 'job_description', 'company_name', 'employment_period')->get();
    $skills = $user->skills()->select('title', 'description')->get();
    $education = $user->education()->select('degree_name', 'institution_name', 'location', 'years_attended', 'additional_information')->get();
    $cover_letter = CoverLetter::where('job_listing_id', $jobListing->id)->first();


    return Inertia::render('JobListing/ListingDetail/CoverLetter', [
      "listing" => $this->listing,
      "tags" => $this->tags,
      "workExperiences" => $workexperiences,
      "education" => $education,
      "skills" => $skills,
      "coverLetter" => $cover_letter
    ]);
  }

  public function documents(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);

    $user = $jobListing->user;

    $workexperiences = $user->workExperiences()->select('job_title', 'job_description', 'company_name', 'employment_period')->get();
    $skills = $user->skills()->select('title', 'description')->get();
    $education = $user->education()->select('degree_name', 'institution_name', 'location', 'years_attended', 'additional_information')->get();
    $cover_letter = CoverLetter::where('job_listing_id', $jobListing->id)->first();


    return Inertia::render('JobListing/ListingDetail/Documents', [
      "listing" => $this->listing,
      "tags" => $this->tags,
      "workExperiences" => $workexperiences,
      "education" => $education,
      "skills" => $skills,
      "coverLetter" => $cover_letter
    ]);
  }

  public function resume(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);
    return Inertia::render('JobListing/ListingDetail/Resume', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }

  public function todo(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);
    return Inertia::render('JobListing/ListingDetail/Todo', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }

  public function timeline(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);
    return Inertia::render('JobListing/ListingDetail/Timeline', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }
}
