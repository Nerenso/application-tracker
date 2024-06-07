<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListingDetailController extends Controller
{

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

    return Inertia::render('JobListing/ListingDetail/Overview', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }

  public function preparation(JobListing $jobListing)
  {
    return Inertia::render('JobListing/ListingDetail/Preparation', [
      "listing" => $this->listing,
      "tags" => $this->tags
    ]);
  }
}
