<?php

namespace App\Jobs;

use App\Events\SummarizeListingJobFinished;
use App\Models\JobListing;
use App\Traits\OpenAIAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SummarizeListingJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OpenAIAssistant;

  public $tries = 3;
  public $timeout = 120;

  private $listing_text;
  private $detected_language;
  private JobListing $job_listing;

  /**
   * Create a new job instance.
   */
  public function __construct(String $detected_language, String $listing_text, JobListing $job_listing)
  {
    $this->detected_language = $detected_language;
    $this->listing_text = $listing_text;
    $this->job_listing = $job_listing;
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $job_title = $this->getJobTitle($this->listing_text);

    $structured_listing_json = $this->getStructuredJobListing($this->listing_text);
    $structured_listing_decoded = json_decode($structured_listing_json);

    $this->job_listing->update([
      "page_title" => $job_title,
      "structured_listing" => $structured_listing_json,
      "contact_name" => $this->job_listing->contact_name ?? $structured_listing_decoded->job_listing->meta_data->first_name,
      "contact_email" => $this->job_listing->contact_email ?? $structured_listing_decoded->job_listing->meta_data->email,
      "contact_phone" => $this->job_listing->contact_phone ?? $structured_listing_decoded->job_listing->meta_data->phone_number,
      "salary_from" => $this->job_listing->salary_from ?? $structured_listing_decoded->job_listing->meta_data->salary_min,
      "salary_to" => $this->job_listing->salary_to ?? $structured_listing_decoded->job_listing->meta_data->salary_max,
      "location" => $this->job_listing->location ?? $structured_listing_decoded->job_listing->meta_data->city,
    ]);

    $this->job_listing->save();

    SummarizeListingJobFinished::dispatch($this->job_listing);
  }


  private function convertToHTML(String $text)
  {
    $splitted_text = explode("\n", $text);

    $prev_element = null;

    $html_text = array_map(function ($text_line) use (&$prev_element) {
      $string_to_add = null;
      $formatted_line = null;

      if ($prev_element == null) {
        $prev_element = $text_line;
      }

      if (substr($text_line, 0, 1) == "-") {
        if (substr($prev_element, 0, 3) === "<ul" || substr($prev_element, 0, 3) === "<li") {
          $formatted_line = substr($text_line, 2);
          $string_to_add = $prev_element = "<li>{$formatted_line}</li>";
          return $string_to_add;
        } else {
          $formatted_line = substr($text_line, 1);
          $string_to_add = $prev_element = "<ul class='list-disc ml-4 mb-4 space-y-1'><li>{$formatted_line}</li>";
          return $string_to_add;
        }
      }

      if (substr($prev_element, -5) == "</li>" && substr($text_line, 0, 1) != '-') {
        $string_to_add = $prev_element = "</ul>{$text_line}";
        return $string_to_add;
      };

      if (substr($text_line, -1) == ":") {
        $formatted_line = substr($text_line, 0, -1);
        $string_to_add = $prev_element = "<h3>{$formatted_line}</h3>";
        return $string_to_add;
      } elseif ($text_line == "") {
        $string_to_add = $prev_element = "";
        return $string_to_add;
      } else {
        $string_to_add = $prev_element = $text_line;
        return $string_to_add;
      }
    }, $splitted_text);

    return join("", $html_text);
  }
}
