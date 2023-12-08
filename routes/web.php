<?php

use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Embed\Embed;

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
  // return Inertia::render('Welcome', [
  //   'canLogin' => Route::has('login'),
  //   'canRegister' => Route::has('register'),
  //   'laravelVersion' => Application::VERSION,
  //   'phpVersion' => PHP_VERSION,
  // ]);


  $embed = new Embed();
  // $info2 = $embed->get('https://www.goedemiddag.nl/vacatures/medior-laravel-developer');
  // $info2 = $embed->get('https://www.kijkenhuiver.nl/vacature-front-end-developer/');
  // $info2 = $embed->get('https://securedesign.nl/vacatures/vacature-junior-php-webdeveloper-hbo-leiden-32-40-uur/');
  $info2 = $embed->get('https://vacatures.rox.nl/medior-backend-developer/nl');
  $info1 = $embed->get('https://enflow.nl/vacatures/laravel-php-developer');
  // $info2 = $embed->get('https://elephantcs.nl/vacatures/php-developer/');



  $listingInfo1 = [
    'pageTitle' => $info1->title,
    'info' => $info1,
    'desc' => $info1->description,
    'url' => $info1->url,
    "companyName" => $info1->providerName,
    "companyUrl" => $info1->providerUrl,
    'img' => $info1->image
  ];

  $listingInfo2 = [
    'pageTitle' => $info2->title,
    'info' => $info2,
    'desc' => $info2->description,
    'url' => $info2->url,
    "companyName" => $info2->providerName,
    "companyUrl" => $info2->providerUrl,
    'img' => $info2->image
  ];

  // dd($info);

  return Inertia::render('Home', [
    'listingInfo1' => $listingInfo1,
    'listingInfo2' => $listingInfo2,
  ]);
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/job-listing', JobListingController::class);


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
