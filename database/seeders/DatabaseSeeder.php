<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use BezhanSalleh\FilamentShield\Resources\RoleResource\Pages\CreateRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create super_admin role (Shield convention)
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );
        
        // Ensure panel_user permission exists (required for panel access)
        Permission::firstOrCreate(
            ['name' => 'panel_user', 'guard_name' => 'web']
        );
        
        // Note: super_admin doesn't need explicit permissions because
        // Shield automatically grants all permissions via Gate::before()

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Faustino Vasquez',
            'email' => 'fvasquez@local.com',
        ]);

        // Assign super_admin role to user
        $admin->assignRole('super_admin');
        
        // Create houses
        $houses = [
            ['name' => 'Tijuana'],
            ['name' => 'Rosarito'],
            ['name' => 'Cuesta Blanca'],
        ];
        
        foreach ($houses as $house) {
            \App\Models\House::create($house);
        }

    }
}
