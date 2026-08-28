<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoleHasPermission;
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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for($i = 1; $i <= 80; $i++){
            RoleHasPermission::create([
                'permission_id' => $i,
                'role_id' => 1,
            ]);
        }
    }
}
