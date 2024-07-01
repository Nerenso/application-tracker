<?php

namespace App\Jobs;

use App\Events\TestJobFinished;
use App\Models\JobListing;
use App\Traits\OpenAIAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OpenAIAssistant;

    public $listingId;

    /**
     * Create a new job instance.
     */
    public function __construct($listingId)
    {
        $this->listingId = $listingId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $listing = JobListing::find($this->listingId);
        // sleep(3);
        $cover_letter = $this->getCoverLetter($listing);

        event(new TestJobFinished($cover_letter));
        // TestJobFinished::dispatch("Does this work?");
    }
}
