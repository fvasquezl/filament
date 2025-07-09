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

        $this->call([
            ShieldSeeder::class,
        ]);

        $users = [
            ['name' => 'Faustino Vasquez', 'email' => 'fvasquez@local.com'],
            ['name' => 'Sebastian Vasquez', 'email' => 'svasquez@local.com']
        ];


        foreach ($users as $user) {
            User::factory()->create($user);
        }

        User::find(1)->assignRole('super_admin');
        User::factory(9)->create();


        $houses = [
            ['name' => 'Tijuana', 'address' => '123 Main St'],
            ['name' => 'Rosarito', 'address' => '456 Elm St'],
            ['name' => 'Cuesta Blanca', 'address' => '789 Oak St'],
        ];

        foreach ($houses as $house) {
            House::create($house);
        }


    }
}
