<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.hu',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        Task::factory(10)->create();
    }
}
