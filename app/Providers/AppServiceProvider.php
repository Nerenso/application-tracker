<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    if ($this->app->environment('local')) {
      $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
      $this->app->register(TelescopeServiceProvider::class);
    }
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // \Debugbar::disable();

    VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
      return (new MailMessage)
        ->view('emails.transactional', ['url' => $url, 'user' => $notifiable, 'name' => 'John']);
    });
  }
}
