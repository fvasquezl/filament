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
use Illuminate\Support\Facades\Storage;

class PostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $post;
    public $imageUrl;
    /**
     * Create a new event instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->imageUrl = $post->image ? \Storage::url($post->image) : null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('posts'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'post.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->post->id,
            'title' => $this->post->title,
            'image' => $this->imageUrl,
            'created_at' => $this->post->created_at,
            'updated_at' => $this->post->updated_at,
            // Agrega aquí cualquier otro campo relevante
        ];
    }
}
