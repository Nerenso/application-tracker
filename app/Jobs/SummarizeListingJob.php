<?php

namespace App\Jobs;

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

    private $assistantId;
    private $listing_text;
    private JobListing $job_listing;

    /**
     * Create a new job instance.
     */
    public function __construct(String $assistantId, String $listing_text, JobListing $job_listing)
    {
        $this->assistantId = $assistantId;
        $this->listing_text = $listing_text;
        $this->job_listing = $job_listing;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = $this->getAssistantResponse($this->assistantId, $this->listing_text);

        $this->job_listing->update([
            "generated_description" => $response
        ]);

        $this->job_listing->save();
    }
}
