<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use App\Models\TimelineActivity;
use Illuminate\Console\Command;
use Ramsey\Uuid\Type\Time;

class CreateInitialTimelineActivities extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:create-initial-timeline-activities';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create initial timeline activities for existing job listings';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    JobListing::chunk(5, function ($listings) {
      foreach ($listings as $listing) {
        $activity = TimelineActivity::create([
          'user_id' => $listing->user_id,
          'job_listing_id' => $listing->id,
          'title' => 'Listing Created',
          'description' => $listing->notes ?? null,
          'activity_date' => $listing->created_at,
          'activity_type' => 'listing_created',
        ]);

        $activity->save();

        $this->info('Created activity for listing ' . $listing->id);
      }
    });
  }
}
