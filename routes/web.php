<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ContactDetailController;
use App\Http\Controllers\CoverLetterController;
use App\Http\Controllers\EducationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ListingDetailController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MarketingPagesController;
use App\Http\Controllers\PreparationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkExperienceController;


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

// Route handling for marketing pages
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


Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {

  Route::get('/', function () {
    return redirect()->route('job-listing.index');
  })->name('dashboard');

  Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
  Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
  Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');

  Route::resource('/contact-details', ContactDetailController::class)->only(['index', 'store', 'update']);
  Route::resource('/certification', CertificationController::class)->only(['index', 'store', 'destroy', 'update']);
  Route::resource('/cover-letter', CoverLetterController::class)->only(['index', 'store', 'destroy', 'update']);
  Route::resource('/education', EducationController::class)->only(['index', 'store', 'destroy', 'update']);
  Route::resource('/preparation', PreparationController::class)->only(['store', 'destroy', 'update']);
  Route::resource('/tag', TagController::class)->only(['index', 'store', 'destroy', 'update']);
  Route::resource('/skill', SkillController::class)->only(['index', 'store', 'destroy', 'update']);
  Route::resource('/work-experience', WorkExperienceController::class)->only(["index", "store", 'destroy', 'update']);

  Route::resource('/job-listing', JobListingController::class)->only(['show', "index", "store", 'destroy', 'update']);

  Route::prefix('/job-listing/{job_listing}')->group(function () {
    Route::get('/overview', [ListingDetailController::class, 'overview'])->name('listing-detail.overview');
    Route::get('/preparation', [ListingDetailController::class, 'preparation'])->name('listing-detail.preparation');
    Route::get('/cover-letter', [ListingDetailController::class, 'coverLetter'])->name('listing-detail.coverLetter');
    Route::get('/cover-letter/pdf', [CoverLetterController::class, 'generatePDF'])->name('pdf-generation.coverLetter');
    Route::get('/resume', [ListingDetailController::class, 'resume'])->name('listing-detail.resume');
    Route::patch('/bookmark', [JobListingController::class, 'toggleBookmarked'])->name('job-listing.bookmark');
    Route::patch('/update-status', [JobListingController::class, 'updateStatus'])->name('job-listing.updateStatus');
    Route::post('/sync-tags', [JobListingController::class, 'syncTags'])->name('job-listing.syncTags');
  });
});


// Route handling for recursively converting extracted job listing data to structured data
Route::match(['get', 'post'], 'management', [ManagementController::class, 'handleRequest'])->middleware('auth')->name('management');

// Experimental and package testing routes



require __DIR__ . '/auth.php';
