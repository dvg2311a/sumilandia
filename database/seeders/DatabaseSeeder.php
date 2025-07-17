<?php

namespace Database\Seeders;

use App\Models\ExerciseType;
use App\Models\Level;
use App\Models\Profile;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        Profile::factory()->create([
            'user_id' => $adminUser->id
        ]);
        $adminUser->assignRole('admin');

        Level::factory()->count(3)->create();

        Unit::factory()->count(4)->create([
            'level_id' => Level::inRandomOrder()->first()->id,
        ]);

        ExerciseType::insert([
            ['name' => 'Multiple Choice', 'description' => 'Multiple choice exercises'], // Opción múltiple
            ['name' => 'Fill in the Blanks', 'description' => 'Exercises to fill in the blanks'], // Completar espacios
            ['name' => 'True or False', 'description' => 'Exercises to determine if statements are true or false'], // Verdadero o falso
            ['name' => 'Matching', 'description' => 'Exercises to match items from two lists'], // Relacionar columnas
            ['name' => 'Ordering', 'description' => 'Exercises to arrange items in the correct order'], // Ordenar elementos
            ['name' => 'Short Answer', 'description' => 'Exercises that require a brief written response'], // Respuesta corta
            ['name' => 'Essay', 'description' => 'Exercises that require a longer written response'], // Ensayo
        ]);
    }
}
