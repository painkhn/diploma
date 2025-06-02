<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'dima',
            'email' => 'dima@gmail.com',
            'password' => Hash::make('123123123')
        ]);
        User::factory()->create([
            'name' => 'den',
            'email' => 'den@gmail.com',
            'password' => Hash::make('123123123')
        ]);
        User::factory()->create([
            'name' => 'sasha',
            'email' => 'sasha@gmail.com',
            'password' => Hash::make('123123123')
        ]);
        User::factory()->create([
            'name' => 'oleg',
            'email' => 'oleg@gmail.com',
            'password' => Hash::make('123123123')
        ]);
    }
}
