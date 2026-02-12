<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create(['email' => 'seller'. $i .'@gmail.com']);
            // $user->assignRole(fake()->randomElement(Role::all()->pluck('name')));
            $user->assignRole('seller');
        }
    }
}
