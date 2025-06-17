<?php

namespace App\Events;

use App\Models\JobListing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SummarizeListingJobFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private JobListing $job_listing;
    /**
     * Create a new event instance.
     */
    public function __construct(JobListing $job_listing)
    {
        $this->job_listing = $job_listing;
    }

    private function getJobListing(): JobListing
    {
        return $this->job_listing;
    }


    public function broadcastWith(): array
    {
        return [
            'status' => 'completed',
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('job-listings.' . $this->getJobListing()->id . '.summarize-listing'),
        ];
    }
}
