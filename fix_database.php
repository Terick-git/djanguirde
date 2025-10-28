<?php
// Script de réparation de la base de données DJANGUIRDE

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 Réparation de la base de données DJANGUIRDE...\n";

// Réinitialiser la base
echo "📋 Réinitialisation des tables...\n";
$kernel->call('migrate:fresh', ['--force' => true]);

// Peupler la base
echo "🌱 Peuplement des données...\n";
$kernel->call('db:seed', ['--force' => true]);

echo "✅ Base de données réparée avec succès !\n";
echo "🎯 Vous pouvez maintenant visiter http://localhost:8000\n";