<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostActivated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return $this->post->houses->map(function ($house) {
            return new PrivateChannel('house.' . $house->id);
        })->all();
    }

    public function broadcastAs(): string
    {
        return 'post.activated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->post->id,
            'title' => $this->post->title,
            'image' => $this->post->image_url, // Usar accessor
            'active' => $this->post->active,
            'created_at' => $this->post->created_at,
            'updated_at' => $this->post->updated_at,
        ];
    }

    // public function broadcastWhen(): bool
    // {
    //     return $this->post->active === true;
    // }
}
