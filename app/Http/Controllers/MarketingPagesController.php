<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class MarketingPagesController extends Controller
{
  public function home()
  {
    return Inertia::render('Marketing/Index', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }

  public function contact()
  {
    return Inertia::render('Marketing/Contact', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }

  public function about()
  {
    return Inertia::render('Marketing/About', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }

  public function pricing()
  {
    return Inertia::render('Marketing/Pricing', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }
}
