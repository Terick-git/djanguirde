<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Vérifier et ajouter chaque colonne seulement si elle n'existe pas
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('users', 'specialization')) {
                $table->string('specialization')->nullable();
            }
            if (!Schema::hasColumn('users', 'access_code')) {
                $table->string('access_code')->nullable();
            }
            if (!Schema::hasColumn('users', 'settings')) {
                $table->json('settings')->nullable();
            }
            if (!Schema::hasColumn('users', 'last_login')) {
                $table->timestamp('last_login')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'bio', 
                'specialization', 
                'access_code', 
                'settings', 
                'last_login'
            ]);
        });
    }
};