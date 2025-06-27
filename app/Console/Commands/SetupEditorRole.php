<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupEditorRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-editor-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Editor role with proper permissions for Posts management';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up Editor role...');

        // Ensure panel_user permission exists (required to access the panel)
        $panelPermission = Permission::firstOrCreate(
            ['name' => 'panel_user', 'guard_name' => 'web']
        );
        $this->info('✅ Panel user permission ready');

        // Create or find Editor role
        $editorRole = Role::firstOrCreate(
            ['name' => 'Editor', 'guard_name' => 'web']
        );
        $this->info('✅ Editor role ready');

        // Define permissions for Editor
        $editorPermissions = [
            'panel_user',        // Required to access the panel
            'view_any_post',     // See posts list
            'view_post',         // View individual posts
            'create_post',       // Create new posts
            'update_post',       // Edit posts
            'delete_post',       // Delete posts
        ];

        // Assign permissions to Editor role
        foreach ($editorPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );
            
            if (!$editorRole->hasPermissionTo($permissionName)) {
                $editorRole->givePermissionTo($permissionName);
                $this->line("  → Added permission: {$permissionName}");
            }
        }

        $this->newLine();
        $this->info('📋 Editor role permissions:');
        foreach ($editorRole->permissions as $permission) {
            $this->line("  • {$permission->name}");
        }

        $this->newLine();
        $this->info('✨ Editor role setup complete!');
        $this->info('Users with Editor role can now:');
        $this->line('  • Access the admin panel');
        $this->line('  • View, create, edit, and delete posts');
        $this->line('  • See Posts in the sidebar');
        
        return Command::SUCCESS;
    }
}
