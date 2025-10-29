<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier d'abord si les colonnes existent
        $columns = DB::select('PRAGMA table_info(users)');
        $columnNames = array_column($columns, 'name');
        
        $this->command->info('Colonnes disponibles: ' . implode(', ', $columnNames));

        // Créer les utilisateurs avec seulement les colonnes disponibles
        $users = [
            [
                'name' => 'Admin DJANGUIRDE',
                'email' => 'admin@djanguirde.com',
                'password' => 'password',
                'role' => 'admin',
                'access_code' => '3xDev',
            ],
            [
                'name' => 'Professeur Mathématiques',
                'email' => 'maths@djanguirde.com', 
                'password' => 'password',
                'role' => 'teacher',
                'specialization' => 'Mathématiques',
                'access_code' => '3xDev',
            ],
            [
                'name' => 'Étudiant Test',
                'email' => 'etudiant@djanguirde.com',
                'password' => 'password', 
                'role' => 'student',
            ],
            [
                'name' => 'Léna Dupont',
                'email' => 'lena@eleve.com',
                'password' => 'password',
                'role' => 'student',
            ]
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                // Construire le tableau de données avec seulement les colonnes disponibles
                $data = [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                ];

                // Ajouter les colonnes supplémentaires seulement si elles existent
                if (in_array('role', $columnNames)) {
                    $data['role'] = $userData['role'];
                }
                if (in_array('access_code', $columnNames) && isset($userData['access_code'])) {
                    $data['access_code'] = $userData['access_code'];
                }
                if (in_array('specialization', $columnNames) && isset($userData['specialization'])) {
                    $data['specialization'] = $userData['specialization'];
                }

                User::create($data);
                $this->command->info("✅ Utilisateur {$userData['email']} créé avec succès!");
            } else {
                $this->command->line("ℹ️ Utilisateur {$userData['email']} existe déjà.");
            }
        }
    }
}