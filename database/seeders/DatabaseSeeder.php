<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory()->create([
            'name' => 'ADMIN',
            'active' => true,
        ]);

        $groups = Group::factory(2)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
        ])->groups()->attach(Group::all());

        User::factory(10)->create()->each(function ($user) use ($groups) {
            $user->groups()->attach($groups->random(2));
        });
    }
}
