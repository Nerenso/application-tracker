<?php

namespace App\Jobs;

use App\Events\CoverLetterGenerationFinished;
use App\Models\CoverLetter;
use App\Models\JobListing;
use App\Traits\OpenAIAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCoverLetterGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OpenAIAssistant;

    private JobListing $jobListing;
    private string $motivation;
    private string $content;
    private string $generationType;

    /**
     * Create a new job instance.
     */
    public function __construct(JobListing $jobListing, string $content, string $motivation, string $generationType)
    {
        $this->jobListing = $jobListing;
        $this->content = $content;
        $this->motivation = $motivation;
        $this->generationType = $generationType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->generationType === "new") {
            $cover_letter = CoverLetter::create([
                "user_id" => $this->jobListing->user_id,
                "job_listing_id" => $this->jobListing->id,
                "motivation" => $this->motivation,
            ]);

            $generated_cover_letter = $this->getCoverLetter($this->content);

            $cover_letter->update([
                "generated_letter" => $generated_cover_letter
            ]);

            $cover_letter->save();

            CoverLetterGenerationFinished::dispatch($cover_letter, $this->jobListing);
        }
    }
}
