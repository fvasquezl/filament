<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Usuario')
                ->icon('heroicon-o-user-plus')
                ->modalHeading('Crear Nuevo Usuario')
                ->modalDescription('Complete los datos para registrar un nuevo usuario en el sistema')
                ->modalIcon('heroicon-o-user-plus')
                ->modalSubmitActionLabel('Crear Usuario')
                ->modalCancelActionLabel('Cancelar')
                ->successNotificationTitle('Usuario creado exitosamente')
                ->successNotification(
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Usuario creado')
                        ->body('El usuario ha sido creado correctamente.')
                ),
        ];
    }
}
