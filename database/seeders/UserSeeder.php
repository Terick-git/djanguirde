<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin DJANGUIRDE',
            'email' => 'admin@djanguirde.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Professeurs/Instructeurs
        $teachers = [
            ['name' => 'Professeure Dupont - Mathématiques', 'email' => 'maths@djanguirde.com', 'role' => 'instructor'],
            ['name' => 'Professeur Martin - Français', 'email' => 'francais@djanguirde.com', 'role' => 'instructor'],
            ['name' => 'Professeure Lambert - Physique', 'email' => 'physique@djanguirde.com', 'role' => 'instructor'],
        ];

        foreach ($teachers as $teacher) {
            User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'role' => $teacher['role'],
            ]);
        }

        // Élèves de test
        $students = [
            ['name' => 'Léa Martin - 3ème', 'email' => 'lea@eleve.com', 'role' => 'student'],
            ['name' => 'Thomas Dubois - Seconde', 'email' => 'thomas@eleve.com', 'role' => 'student'],
            ['name' => 'Marie Lambert - Terminale', 'email' => 'marie@eleve.com', 'role' => 'student'],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'role' => $student['role'],
            ]);
        }
    }
}