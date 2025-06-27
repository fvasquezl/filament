<?php

use App\Events\PostCreated;
use App\Models\Post;

// Get the latest post
$post = Post::latest()->first();

if ($post) {
    echo "Broadcasting PostCreated event for post: {$post->title}\n";
    echo "Image path: {$post->image}\n";
    echo "Image URL: {$post->image_url}\n";
    
    // Broadcast the event
    broadcast(new PostCreated($post));
    
    echo "Event broadcasted successfully!\n";
} else {
    echo "No posts found in database\n";
}