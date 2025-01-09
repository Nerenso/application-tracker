<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertToStructuredListing;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManagementController extends Controller
{
  public function handleRequest(Request $request)
  {
    if ($request->isMethod('get')) {

      return Inertia::render('Management');
    } elseif ($request->isMethod('post')) {

      if ($request->function_name === 'convertListings') {
        $this->convertListings();
      }
    }
  }

  private function convertListings()
  {
    $listings = JobListing::query()
      ->where("listing_plain_text", "!=", null)
      ->orderBy('created_at', 'desc')
      ->get();

    foreach ($listings as $listing) {
      ConvertToStructuredListing::dispatch($listing);
    }

    return redirect()->back()->with(["success" => "Listings Convertion Started"]);
  }
}
