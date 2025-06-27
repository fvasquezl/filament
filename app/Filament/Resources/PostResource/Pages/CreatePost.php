<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Events\PostCreated;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $post = $this->record->fresh();
        Log::info('Post image URL: ' . Storage::url($post->image));
        // Disparar el evento de broadcasting cuando se crea un post
        broadcast(new PostCreated($post))->toOthers();
    }
}
