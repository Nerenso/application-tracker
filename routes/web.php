<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ContactDetailController;
use App\Http\Controllers\CoverLetterController;
use App\Http\Controllers\EducationController;
use Embed\Embed;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ListingDetailController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MarketingPagesController;
use App\Http\Controllers\PreparationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkExperienceController;
use App\Jobs\ProcessTestJob;
use App\Models\JobListing;
use Stevebauman\Hypertext\Transformer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(MarketingPagesController::class)->group(function () {
  Route::get("/", "home")->name("marketing.index");
  Route::get("/contact", "contact")->name("marketing.contact");
  Route::post("/contact", "contactForm")->name("marketing.contact-form");
  Route::get("/about", "about")->name("marketing.about");
  Route::get("/pricing", "pricing")->name("marketing.pricing");
  Route::get("/faq", "FAQ")->name("marketing.faq");
  Route::get("/terms-of-service", "terms")->name("marketing.terms-of-service");
  Route::get("/privacy-policy", "privacy")->name("marketing.privacy-policy");
});



Route::get('/dashboard', function () {
  // return Inertia::render('Dashboard');
  return redirect()->route('job-listing.index');
})->middleware('auth', 'verified')->name('dashboard');

Route::get("/test", function (Request $request) {
  $listingId = $request->listingId;

  if (!$listingId) {
    $listingId = 175;
  }

  return Inertia::render("Test", []);
})->name("test");

Route::get("/format", function (Request $request) {});

Route::post("/test", function (Request $request) {
  $job_listing = JobListing::find($request->job_listing_id);
  $job_listing->tags()->sync($request->selectedMultiple);
  return 'Hello';
});

Route::match(['get', 'post'], 'management', [ManagementController::class, 'handleRequest'])->middleware('auth')->name('management');

Route::post('/dashboard/job-listing/{job_listing}/sync-tags', [JobListingController::class, 'syncTags'])->name('job-listing.syncTags')->middleware('auth');


Route::resource('/dashboard/job-listing', JobListingController::class)->only(['show', "index", "store", 'destroy', 'update'])->middleware(['auth', 'verified']);
Route::patch('/dashboard/job-listing/{job_listing}/bookmark', [JobListingController::class, 'toggleBookmarked'])->name('job-listing.bookmark')->middleware(['auth', 'verified']);

Route::resource('/dashboard/work-experience', WorkExperienceController::class)->only(["index", "store", 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/contact-details', ContactDetailController::class)->only(['index', 'store', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/tag', TagController::class)->only(['index', 'store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/education', EducationController::class)->only(['index', 'store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/skill', SkillController::class)->only(['index', 'store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/certification', CertificationController::class)->only(['index', 'store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/cover-letter', CoverLetterController::class)->only(['index', 'store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/preparation', PreparationController::class)->only(['store', 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::prefix('dashboard')->middleware('auth')->group(function () {
  Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
  Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
  Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

Route::prefix('dashboard/job-listing/{job_listing}')->middleware('auth')->group(function () {
  Route::get('/overview', [ListingDetailController::class, 'overview'])->name('listing-detail.overview');
  Route::get('/preparation', [ListingDetailController::class, 'preparation'])->name('listing-detail.preparation');
  Route::get('/cover-letter', [ListingDetailController::class, 'coverLetter'])->name('listing-detail.coverLetter');
  Route::get('/resume', [ListingDetailController::class, 'resume'])->name('listing-detail.resume');
});

Route::get('/pdf', [CoverLetterController::class, 'pdf'])->name('pdf');

Route::prefix('pdf-generation')->middleware('auth')->group(function () {
  Route::get('/job-listing/{job_listing}/cover-letter', [CoverLetterController::class, 'generatePDF'])->name('pdf-generation.coverLetter');
});


Route::get('/test-email', function () {
  return view('emails.verify-email', [
    'user' => request()->user(),
    'url' => 'https://www.google.com',
  ]);
});


require __DIR__ . '/auth.php';
