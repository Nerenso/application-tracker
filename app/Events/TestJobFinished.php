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

class TestJobFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;
    public $listing_text;
    public $company_name;
    public $cover_letter;

    public function __construct($cover_letter)
    {
        // $this->message = $message;
        // $this->listing_text = $jobListing->listing_plain_text;
        // $this->company_name = $jobListing->company_name;

        $this->cover_letter = $cover_letter;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('test-job'),
        ];
    }
}
