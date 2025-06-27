<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionObserver
{
    /**
     * Handle any role permission sync event.
     */
    public function synced(Role $role): void
    {
        $this->clearPermissionCache();
    }

    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $this->clearPermissionCache();
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $this->clearPermissionCache();
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $this->clearPermissionCache();
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        $this->clearPermissionCache();
    }

    /**
     * Clear the permission cache
     */
    protected function clearPermissionCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}