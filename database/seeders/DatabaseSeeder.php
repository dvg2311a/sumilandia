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

        Level::insert([
            ['name' => 'Básico', 'description' => 'Nivel inicial para comenzar el aprendizaje desde cero.'],
            ['name' => 'Intermedio', 'description' => 'Nivel para reforzar y ampliar conocimientos previos.'],
            ['name' => 'Avanzado', 'description' => 'Nivel para dominar y profundizar en los temas más complejos.'],
        ]);

        Unit::insert([
            ['name' => 'Números y operaciones básicas', 'description' => 'Que el estudiante aprenda a reconocer y operar con números naturales y operaciones aritméticas simples.', 'expected_time' => 30, 'level_id' => 1],
            ['name' => 'Álgebra básica', 'description' => 'Introducción a las variables, ecuaciones y expresiones algebraicas.', 'expected_time' => 45, 'level_id' => 2],
            ['name' => 'Geometría y medidas', 'description' => 'Conceptos básicos de geometría, figuras y medidas.', 'expected_time' => 40, 'level_id' => 3],
            ['name' => 'Estadística y probabilidad', 'description' => 'Fundamentos de la estadística descriptiva y probabilidad.', 'expected_time' => 50, 'level_id' => 3],
        ]);

        ExerciseType::insert([
            ['name' => 'Opción múltiple', 'description' => 'Ejercicios de opción múltiple'],
            ['name' => 'Completar espacios', 'description' => 'Ejercicios para completar espacios en blanco'],
            ['name' => 'Verdadero o falso', 'description' => 'Ejercicios para determinar si las afirmaciones son verdaderas o falsas'],
            ['name' => 'Relacionar columnas', 'description' => 'Ejercicios para relacionar elementos de dos listas'],
            ['name' => 'Ordenar elementos', 'description' => 'Ejercicios para ordenar elementos en el orden correcto'],
            ['name' => 'Respuesta corta', 'description' => 'Ejercicios que requieren una respuesta breve escrita'],
            ['name' => 'Ensayo', 'description' => 'Ejercicios que requieren una respuesta escrita más extensa'],
        ]);
    }
}
