<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
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

  public function contactForm(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string',
      'email' => 'required|email',
      'message' => 'required|string',
    ]);

    // Mail::to('Nerenso@hotmail.com')->send(new ContactFormSubmission($validated['name'], $validated['email'], $validated['message']));

    Mail::html($validated['message'], function (Message $message) use ($validated) {
      $message
        ->replyTo($validated['email'], $validated['name'])
        ->from('no-reply@rebelfox.dev', 'Jobdeck')
        ->subject('Contact Form Submission')
        ->to('Nerenso@hotmail.com');
    });

    return redirect()->back()->with(['success' => "Message Sent"]);
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

  public function FAQ()
  {
    return Inertia::render('Marketing/FAQ', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }

  public function terms()
  {
    return Inertia::render('Marketing/Service', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }

  public function privacy()
  {
    return Inertia::render('Marketing/Privacy', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
    ]);
  }
}
