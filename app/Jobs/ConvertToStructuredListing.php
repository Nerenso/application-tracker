<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Traits\OpenAIAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertToStructuredListing implements ShouldQueue
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

    public function __construct(JobListing $job_listing)
    {
        $this->job_listing = $job_listing;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $structured_listing = $this->listingConverter($this->job_listing->listing_plain_text);

        $this->job_listing->update([
            "structured_listing" => $structured_listing
        ]);

        $this->job_listing->save();
    }
}
