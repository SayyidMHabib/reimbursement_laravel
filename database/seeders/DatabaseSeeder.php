<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nip' => '1234',
            'name' => 'Doni',
            'email' => 'doni@example.com',
            'password' => bcrypt('123456'),
            'status' => 'Direktur',
        ]);

        \App\Models\User::factory()->create([
            'nip' => '1235',
            'name' => 'Dono',
            'email' => 'dono@example.com',
            'password' => bcrypt('123456'),
            'status' => 'Finance',
        ]);

        \App\Models\User::factory()->create([
            'nip' => '1236',
            'name' => 'Dona',
            'email' => 'dona@example.com',
            'password' => bcrypt('123456'),
            'status' => 'Staff',
        ]);
    }
}
