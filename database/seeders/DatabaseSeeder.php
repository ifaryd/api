<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@admin.com',
            'telephone' => '+23239877',
            'avatar' => 'admin.png',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Root',
            'last_name' => 'User',
            'email' => 'root@root.com',
            'telephone' => '+23239877',
            'avatar' => 'root.png',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Manager',
            'last_name' => 'User',
            'email' => 'manager@manager.com',
            'telephone' => '+23239877',
            'avatar' => 'manager.png',
        ]);
    }
}
