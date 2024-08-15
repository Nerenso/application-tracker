<?php

namespace App\Jobs;

use App\Events\PreparationQuestionsGenerationFinished;
use App\Models\JobListing;
use App\Models\Preparation;
use App\Traits\OpenAIAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessPreparationQuestionsGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OpenAIAssistant;

    private JobListing $job_listing;
    private string $content;

    /**
     * Create a new job instance.
     */
    public function __construct(JobListing $job_listing, string $content)
    {
        $this->job_listing = $job_listing;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $preparation = Preparation::create([
            'user_id' => $this->job_listing->user_id,
            'job_listing_id' => $this->job_listing->id,
        ]);

        $generatedQuestions = $this->getPreparationQuestions($this->content, $this->job_listing->listing_language);

        $preparation->update([
            'suggested_questions' => $generatedQuestions
        ]);

        $preparation->save();

        PreparationQuestionsGenerationFinished::dispatch($preparation, $this->job_listing);
    }
}
