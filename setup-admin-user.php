<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Find the user
$user = User::where('email', 'fvasquez@local.com')->first();

if (!$user) {
    echo "❌ User fvasquez@local.com not found!\n";
    exit(1);
}

echo "✅ Found user: {$user->name} ({$user->email})\n";

// Create or find Admin role
$adminRole = Role::firstOrCreate(
    ['name' => 'Admin', 'guard_name' => 'web']
);
echo "✅ Admin role ready\n";

// Ensure panel_user permission exists
Permission::firstOrCreate(
    ['name' => 'panel_user', 'guard_name' => 'web']
);

// Give Admin role ALL permissions
$allPermissions = Permission::all();
$adminRole->syncPermissions($allPermissions);
echo "✅ Admin role has been granted all permissions (" . $allPermissions->count() . " permissions)\n";

// Assign Admin role to user
$user->assignRole('Admin');
echo "✅ Admin role assigned to {$user->email}\n";

echo "\n📋 User roles:\n";
foreach ($user->roles as $role) {
    echo "  • {$role->name}\n";
}

echo "\n✨ Done! {$user->email} is now an Admin with full access.\n";