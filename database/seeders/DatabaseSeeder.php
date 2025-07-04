<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [
            ['name' => 'Faustino Vasquez', 'email' => 'fvasquez@local.com'],
            ['name' => 'Sebastian Vasquez', 'email' => 'svasquez@local.com']
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        $houses = [
            ['name' => 'Tijuana', 'address' => '123 Main St'],
            ['name' => 'Rosarito', 'address' => '456 Elm St'],
            ['name' => 'Costa Blanca', 'address' => '789 Oak St'],
        ];

        foreach ($houses as $house) {
            House::create($house);
        }

    }
}
