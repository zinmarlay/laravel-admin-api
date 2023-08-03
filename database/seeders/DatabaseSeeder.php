<?php

namespace Database\Seeders;

use App\Models\Role;
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
        Role::factory()->create([
            'name' => 'Admin'
        ]);

        Role::factory()->create([
            'name' => 'Editor'
        ]);

        Role::factory()->create([
            'name' => 'Viewer'
        ]);

        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
            'first-name' => 'Admin',
            'last-name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id'=> 1,
        ]);

        \App\Models\User::factory()->create([
            'first-name' => 'Editor',
            'last-name' => 'Editor',
            'email' => 'editor@editor.com',
            'role_id'=> 2,
        ]);

        \App\Models\User::factory()->create([
            'first-name' => 'Viewer',
            'last-name' => 'Viewer',
            'email' => 'viewer@viewer.com',
            'role_id'=> 3,
        ]);
    }
}
