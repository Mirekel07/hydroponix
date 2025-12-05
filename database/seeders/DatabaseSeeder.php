<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'User',
            'email' => 'User@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'TestAdmin',
            'email' => 'testadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call([
            PlantSeeder::class,
            PlantMissionSeeder::class,
            ModuleSeeder::class,
            QuizSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
