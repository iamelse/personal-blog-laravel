<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
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

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        $this->call(PermissionSeeder::class);

        $user = User::find(1);
        $user->assignRole(RoleEnum::MASTER->value);

        Role::factory()->count(100)->create();
        User::factory()->count(100)->create();

        $this->call(SectionSeeder::class);
        $this->call(SkillSeeder::class);
    }
}
