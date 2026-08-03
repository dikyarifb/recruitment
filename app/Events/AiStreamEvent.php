<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AiStreamEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $conversationId;
    public $delta;

    public function __construct($conversationId, $delta)
    {
        $this->conversationId = $conversationId;
        $this->delta = $delta;
    }

    public function broadcastOn()
    {
        return new Channel('ai-chat.'.$this->conversationId);
    }

    public function broadcastAs()
    {
        return 'token';
    }
}