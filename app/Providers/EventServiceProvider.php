<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Listeners\BroadcastPostCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\Models\Role;
use App\Observers\RolePermissionObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostCreated::class => [
            BroadcastPostCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Register the observer for Role model
        Role::observe(RolePermissionObserver::class);
        
        // Listen for permission sync events
        Event::listen('eloquent.pivotAttached: ' . Role::class, function ($event, $data) {
            if ($data[1] === 'permissions') {
                app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            }
        });
        
        Event::listen('eloquent.pivotDetached: ' . Role::class, function ($event, $data) {
            if ($data[1] === 'permissions') {
                app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            }
        });
        
        Event::listen('eloquent.pivotUpdated: ' . Role::class, function ($event, $data) {
            if ($data[1] === 'permissions') {
                app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}