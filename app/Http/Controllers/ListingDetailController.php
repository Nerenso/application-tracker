<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
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
    return Inertia::render('JobListing/ListingDetail/Preparation', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }

  public function coverLetter(JobListing $jobListing)
  {
    Gate::authorize('view', $jobListing);

    // $this->getCoverLetter($jobListing);
    $user = $jobListing->user;

    // $candidate = [
    //   "workexperiences" => $user->workExperiences()->select('job_title', 'company_name', 'job_description')->get(),
    //   "skills" => $user->skills()->select('title', 'description')->get(),
    //   "education" => $user->education()->select('degree_name', 'institution_name', 'location', 'years_attended', 'academic_progress', 'additional_information')->get(),
    //   "certifications" => $user->certifications()->select('title')->get()
    // ];

    $workexperiences = $user->workExperiences()->get();
    // $skills = $user->skills()->select('title', 'description')->get();
    // $education = $user->education()->select('degree_name', 'institution_name', 'location', 'years_attended', 'academic_progress', 'additional_information')->get();


    // // dd($workexperiences);

    return Inertia::render('JobListing/ListingDetail/CoverLetter', [
      "listing" => $this->listing,
      "tags" => $this->tags,
      "workExperiences" => $workexperiences
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
}
