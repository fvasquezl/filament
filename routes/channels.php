<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('house.{houseId}', function ($user, $houseId) {
    // Permitir acceso si el usuario está autenticado y pertenece a la casa
    \Log::info('Channel authorization for house.' . $houseId, [
        'user_id' => $user->id,
        'user_house_id' => $user->house_id,
        'requested_house_id' => $houseId
    ]);
    
    return $user !== null && $user->house_id == $houseId;
});
