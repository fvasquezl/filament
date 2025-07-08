<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof CreateUser)
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\Select::make('house_id')
                    ->relationship('house', 'name')
                    ->preload()
                    ->placeholder('Seleccione una casa')
                    ->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('house.name')
                    ->icon('heroicon-o-home')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square')
                    ->modalHeading('Editar Usuario')
                    ->modalDescription('Modifique los datos del usuario según sea necesario')
                    ->modalIcon('heroicon-o-pencil-square')
                    ->modalSubmitActionLabel('Guardar Cambios')
                    ->modalCancelActionLabel('Cancelar')
                    ->successNotificationTitle('Usuario actualizado exitosamente')
                    ->successNotification(
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Usuario actualizado')
                            ->body('Los datos del usuario han sido actualizados correctamente.')
                    ),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Eliminar Usuario')
                    ->modalDescription('¿Está seguro que desea eliminar este usuario? Esta acción no se puede deshacer.')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->modalCancelActionLabel('Cancelar')
                    ->successNotificationTitle('Usuario eliminado exitosamente')
                    ->successNotification(
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Usuario eliminado')
                            ->body('El usuario ha sido eliminado correctamente.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Usuarios eliminados exitosamente')
                        ->successNotification(
                            \Filament\Notifications\Notification::make()
                                ->success()
                                ->title('Usuarios eliminados')
                                ->body('Los usuarios seleccionados han sido eliminados correctamente.')
                        ),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
