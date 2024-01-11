<?php

namespace App\Http\Controllers;

use Embed\Embed;
use App\Models\Tag;
use Inertia\Inertia;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Stevebauman\Hypertext\Transformer;
use Illuminate\Contracts\Database\Query\Builder;
use OpenAI\Laravel\Facades\OpenAI;
use App\Traits\OpenAIAssistant;

class JobListingController extends Controller
{
  use OpenAIAssistant;

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
        ->paginate(4)->onEachSide(0),
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

    $transformer = new Transformer();
    $embed = new Embed();

    $url = $embed->get($validated["job_link"]);

    $document = $url->getDocument();

    $html = (string) $document;

    $listing_plain_text = $transformer->keepNewLines()->toText($html);

    // $result = OpenAI::threads()->createAndRun([
    //   'assistant_id' => "asst_lAhxuxqaMkPzwcwY6PTHKM8l",
    //   "thread" => [
    //     'messages' => [
    //       [
    //         "role" => "user",
    //         "content" => $listing_plain_text
    //       ]
    //     ]
    //   ]
    // ]);

    // $this->generateAssistantResponse("asst_lAhxuxqaMkPzwcwY6PTHKM8l", $listing_plain_text);

    $this->testResponse("asst_lAhxuxqaMkPzwcwY6PTHKM8l", $listing_plain_text);



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
      'listing_plain_text' => $listing_plain_text
    ];

    $createdListing = JobListing::create($listing);

    $createdListing->tags()->sync($validated['selectedMultiple']);

    $createdListing->save();

    return redirect(route('job-listing.index'))->with(['success' => "Listing Successfully Added!"]);
  }

  /**
   * Display the specified resource.
   */
  public function show(JobListing $jobListing)
  {
    $listing = JobListing::query()->where('id', $jobListing->id)->with('tags', function (Builder $query) {
      $query->orderBy('title', "ASC");
    })->get()->first();

    return Inertia::render('JobListing/Show', [
      "listing" => $listing
    ]);
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
    $jobListing->delete();

    return redirect(route('job-listing.index'))->with(["success" => "Listing Deleted"]);
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
