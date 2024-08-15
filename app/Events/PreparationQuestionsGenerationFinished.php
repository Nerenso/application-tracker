<?php

namespace App\Events;

use App\Models\JobListing;
use App\Models\Preparation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PreparationQuestionsGenerationFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Preparation $preparation;
    private JobListing $job_listing;

    /**
     * Create a new event instance.
     */
    public function __construct(Preparation $preparation, JobListing $job_listing)
    {
        $this->preparation = $preparation;
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
            new PrivateChannel('job-listings.' . $this->job_listing->id . '.preparation-questions'),
        ];
    }
}
