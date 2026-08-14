<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $rollen = [
            'administrator' => 1,
            'spediteur' => 1,
            'kassenkraft' => 2,
            'lagermitarbeiter' => 2,
        ];


        foreach ($rollen as $rolle => $anzahl)
        {
            for ($i = 1; $i <= $anzahl; $i++)
            {
                User::create([
                    'name' => $rolle .''.$i,
                    'email' => $rolle . $i.'@neumann.de',
                    'password' => 'P@ssw0rt098',
                    'role' => $rolle,
                ]);
            }
        }
        $kunde = User::create([
            'name' => 'Kunde',
            'email' => 'kunde@test.de',
            'password' => 'Kunde1Test!',
            'role' => 'kunde',
        ]);

        Customer::create([
            'user_id' => $kunde->id,
            'name' => 'TestKunde',
            'type' => 'gewerblich',
            'street' => 'Kundenstraße',
            'house_number' => '1',
            'postal_code' => '12345',
            'city' => 'Hamburg',
        ]);
    }
}
