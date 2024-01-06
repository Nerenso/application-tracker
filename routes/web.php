<?php

use Embed\Embed;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\TagController;
use App\Models\JobListing;
use App\Models\Tag;
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
})->middleware(['auth', 'verified'])->name('dashboard');

route::get("/test", function (Request $request) {
  $embed = new Embed();
  $transformer = new Transformer();

  $document = $embed->get('https://enflow.nl/vacatures/laravel-php-developer')->getDocument();

  $html = (string) $document;
  $text = $transformer->keepNewLines()->toText($html);
  dd($text);

  // return Inertia::render("Test", [
  //   'tags' => Tag::where("user_id", auth()->user()->id)->get()
  // ]);
});

route::post("/test", function (Request $request) {
  $job_listing = JobListing::find($request->job_listing_id);
  $job_listing->tags()->sync($request->selectedMultiple);
  return 'Hello';
});

Route::post('/job-listing/{job_listing}/add-tags', [JobListingController::class, 'addTags'])->name('job-listing.addTags');

Route::resource('/dashboard/job-listing', JobListingController::class)->only(['show', "index", "store", 'destroy'])->middleware('auth');

Route::resource('/tag', TagController::class)->only(['store']);

Route::prefix('dashboard')->middleware('auth')->group(function () {
  Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
  Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
  Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});





require __DIR__ . '/auth.php';
