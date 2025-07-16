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

        ExerciseType::factory()->count(5)->create();
    }
}
