<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource extends Resource
{
    /**
     * Determine if the resource navigation should be registered based on permissions.
     */
    public static function shouldRegisterNavigation(): bool
    {
        try {
            // If no authenticated user, don't show navigation
            if (!auth()->check()) {
                return false;
            }
            
            // Get the model name in lowercase for permission check
            $modelName = str(static::getModel())
                ->afterLast('\\')
                ->lower()
                ->snake()
                ->toString();
            
            $permission = "view_any_{$modelName}";
            
            // Check if user can view any of this resource
            return auth()->user()->can($permission);
        } catch (\Exception $e) {
            // Log error but don't crash
            if (app()->environment('local')) {
                logger()->error("Error in shouldRegisterNavigation", [
                    'resource' => static::class,
                    'error' => $e->getMessage()
                ]);
            }
            return false;
        }
    }
    
    /**
     * Check if user can view the index page
     */
    public static function canViewAny(): bool
    {
        $modelName = str(static::getModel())
            ->afterLast('\\')
            ->lower()
            ->snake()
            ->toString();
            
        return auth()->user()->can("view_any_{$modelName}");
    }
}