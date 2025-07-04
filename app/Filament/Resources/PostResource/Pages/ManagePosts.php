<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePosts extends ManageRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(fn(array $data) => array_merge($data, [
                    'user_id' => auth()->id(), // Automatically set the user ID to the authenticated user
                ]))
                ->label('Nuevo Post'),
        ];
    }
}
