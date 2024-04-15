<?php

use App\Http\Controllers\ContactDetailController;
use Embed\Embed;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkExperienceController;
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

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  // return Inertia::render('Dashboard');
  return redirect()->route('job-listing.index');
})->middleware('auth', 'verified')->name('dashboard');

Route::get("/test", function (Request $request) {
  $embed = new Embed();
  $transformer = new Transformer();

  $document = $embed->get('https://enflow.nl/vacatures/laravel-php-developer')->getDocument();

  $html = (string) $document;
  $text = $transformer->keepNewLines()->toText($html);
  dd($text);
});

Route::get("/format", function (Request $request) {
});

Route::post("/test", function (Request $request) {
  $job_listing = JobListing::find($request->job_listing_id);
  $job_listing->tags()->sync($request->selectedMultiple);
  return 'Hello';
});

Route::post('/dashboard/job-listing/{job_listing}/sync-tags', [JobListingController::class, 'syncTags'])->name('job-listing.syncTags')->middleware('auth');

// Route::post('/dashboard/job-listing/{job_listing}/update-listing-info', [JobListingController::class, 'updateListingInfo'])->name('job-listing.updateListingInfo')->middleware('auth');

Route::resource('/dashboard/job-listing', JobListingController::class)->only(['show', "index", "store", 'destroy', 'update'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/work-experience', WorkExperienceController::class)->only(["index", "store", 'destroy', 'update'])->middleware('auth', 'verified');

Route::resource('/dashboard/contact-details', ContactDetailController::class)->only(['index', 'store', 'update'])->middleware(['auth', 'verified']);

Route::resource('/tag', TagController::class)->only(['store']);

Route::prefix('dashboard')->middleware('auth')->group(function () {
  Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
  Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
  Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';
