<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'fname' => 'Test',
            'lname' => 'User',
            'email' => 'steevengreen3211@gmail.com',
        ]);

        Admin::factory()->create([
            'fname' => 'Super',
            'lname' => 'Admin',
            'role' => 'super_admin',
            'email' => 'steevengreen3211@gmail.com',
        ]);
    }
}
