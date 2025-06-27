<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'svasquez@local.com')->first();

if (!$user) {
    echo "❌ Usuario svasquez@local.com no encontrado\n";
    exit;
}

echo "✅ Usuario encontrado: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "ID: {$user->id}\n";

// Reset password
$user->password = Hash::make('12345678');
$user->save();

echo "\n✅ Contraseña actualizada a: 12345678\n";
echo "Ahora puedes hacer login con estas credenciales.\n";