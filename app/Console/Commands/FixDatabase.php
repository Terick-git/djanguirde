<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FixDatabase extends Command
{
    protected $signature = 'fix:database';
    protected $description = 'Réparer la base de données DJANGUIRDE';

    public function handle()
    {
        $this->info('🔧 Réparation de la base de données...');

        // Supprimer toutes les migrations personnalisées problématiques
        $this->deleteProblematicMigrations();

        // Réinitialiser
        $this->call('migrate:fresh', ['--force' => true]);
        
        // Peupler
        $this->call('db:seed', ['--force' => true]);

        $this->info('✅ Base de données réparée avec succès !');
        $this->info('🎯 Vous pouvez maintenant tester : http://localhost:8000');
    }

    private function deleteProblematicMigrations()
    {
        $files = [
            '2025_10_08_185611_add_video_type_to_lessons_table.php',
            '2025_10_07_235759_create_djanguirde_tables.php',
        ];

        foreach ($files as $file) {
            $path = database_path('migrations/' . $file);
            if (file_exists($path)) {
                unlink($path);
                $this->info("🗑️ Supprimé: $file");
            }
        }
    }
}