<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRolePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-role-permissions 
                            {role : The name of the role}
                            {--permissions=* : List of permissions to assign}
                            {--resource= : Assign all permissions for a specific resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign permissions to a role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->argument('role');
        $permissions = $this->option('permissions');
        $resource = $this->option('resource');

        // Find or create role
        $role = Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web']
        );
        $this->info("Working with role: {$roleName}");

        // Always ensure panel_user permission for any role
        $panelPermission = Permission::firstOrCreate(
            ['name' => 'panel_user', 'guard_name' => 'web']
        );
        
        if (!$role->hasPermissionTo('panel_user')) {
            $role->givePermissionTo('panel_user');
            $this->line("  → Added permission: panel_user (required for panel access)");
        }

        // If resource option is used, add all permissions for that resource
        if ($resource) {
            $resourcePermissions = [
                "view_any_{$resource}",
                "view_{$resource}",
                "create_{$resource}",
                "update_{$resource}",
                "delete_{$resource}",
                "restore_{$resource}",
                "force_delete_{$resource}",
            ];

            foreach ($resourcePermissions as $permissionName) {
                if (Permission::where('name', $permissionName)->exists()) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if (!$role->hasPermissionTo($permissionName)) {
                        $role->givePermissionTo($permissionName);
                        $this->line("  → Added permission: {$permissionName}");
                    }
                }
            }
        }

        // If specific permissions are provided
        if (!empty($permissions)) {
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web']
                );
                
                if (!$role->hasPermissionTo($permissionName)) {
                    $role->givePermissionTo($permissionName);
                    $this->line("  → Added permission: {$permissionName}");
                }
            }
        }

        $this->newLine();
        $this->info("📋 {$roleName} role permissions:");
        foreach ($role->permissions as $permission) {
            $this->line("  • {$permission->name}");
        }

        return Command::SUCCESS;
    }
}