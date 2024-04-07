<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conference::create([
            'name' => 'Conference 1',
            'description' => 'Description for Conference 1',
            'date' => '2024-04-15',
            'address' => '123 Main St, City',
        ]);

        Conference::create([
            'name' => 'Conference 2',
            'description' => 'Description for Conference 2',
            'date' => '2024-05-20',
            'address' => '456 Elm St, Town',
        ]);

        // Add more conferences as needed...
    }
}
