<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'neumann@test.com'],
            [
                'name' => 'Neumann',
                'password' => Hash::make('neumanntestpw123'),
                'email_verified_at' => now(),
            ],
        );
    }
}
