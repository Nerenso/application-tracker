<?php

namespace App\Events;

use App\Models\CoverLetter;
use App\Models\JobListing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoverLetterGenerationFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CoverLetter $cover_letter;
    private JobListing $job_listing;

    /**
     * Create a new event instance.
     */
    public function __construct(CoverLetter $cover_letter, JobListing $job_listing)
    {
        $this->cover_letter = $cover_letter;
        $this->job_listing = $job_listing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        return [
            new PrivateChannel('job-listings.' . $this->job_listing->id . '.cover-letter'),
        ];
    }
}
