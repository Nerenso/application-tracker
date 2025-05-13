<?php

namespace App\Services\Timeline;

use App\Models\JobListing;
use App\Models\TimelineActivity;
use Carbon\Carbon;

class TimelineActivityService
{

  /**
   * Create a timeline activity
   * 
   * @param JobListing $jobListing
   * @param array{
   *   title: string,
   *   description?: string|null,
   *   activity_date?: string|Carbon|null,
   *   activity_type: string,
   * }
   */
  public function createTimelineActivity(JobListing $jobListing, array $activity_data)
  {
    $timelineActivity = TimelineActivity::create([
      'user_id' => $jobListing->user_id,
      'job_listing_id' => $jobListing->id,
      'title' => $activity_data['title'],
      'description' => $activity_data['description'] ?? null,
      'activity_date' => isset($activity_data['activity_date']) ? Carbon::parse($activity_data['activity_date']) : now(),
      'activity_type' => $activity_data['activity_type'],
    ]);

    $timelineActivity->save();
  }
}
