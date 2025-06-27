<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EnsureRolesPanelAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ensure-roles-panel-access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure all roles (except super_admin) have panel_user permission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ensuring all roles have panel access...');
        
        // Ensure panel_user permission exists
        $panelPermission = Permission::firstOrCreate(
            ['name' => 'panel_user', 'guard_name' => 'web']
        );
        
        // Get all roles except super_admin
        $roles = Role::where('name', '!=', 'super_admin')->get();
        
        foreach ($roles as $role) {
            if (!$role->hasPermissionTo('panel_user')) {
                $role->givePermissionTo('panel_user');
                $this->line("✅ Added panel_user permission to role: {$role->name}");
            } else {
                $this->line("ℹ️  Role {$role->name} already has panel_user permission");
            }
        }
        
        $this->newLine();
        $this->info('✨ All roles now have panel access!');
        
        return Command::SUCCESS;
    }
}