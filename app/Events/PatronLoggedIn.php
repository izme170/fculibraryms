<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatronLoggedIn implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $patron;

    public function __construct($patron)
    {
        $this->patron = $patron;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new channel('patron.logged.in'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'patron' => [
                'id' => $this->patron->patron_id,
                'name' => $this->patron->first_name . ' ' . $this->patron->last_name,
                'image' => $this->patron->patron_image
                    ? asset('storage/' . $this->patron->patron_image)
                    : asset('img/default-patron-image.png'),
                'login_at' => Carbon::now()->setTimezone('Asia/Manila')->format('g:i a')
            ]
        ];
    }
}
