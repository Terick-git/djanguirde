<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter les colonnes manquantes à la table courses
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'duration')) {
                $table->integer('duration')->default(0)->after('level');
            }
            if (!Schema::hasColumn('courses', 'video_count')) {
                $table->integer('video_count')->default(0)->after('duration');
            }
            if (!Schema::hasColumn('courses', 'view_count')) {
                $table->integer('view_count')->default(0)->after('video_count');
            }
            if (!Schema::hasColumn('courses', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('view_count');
            }
            if (!Schema::hasColumn('courses', 'order')) {
                $table->integer('order')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('courses', 'objectives')) {
                $table->json('objectives')->nullable()->after('order');
            }
            if (!Schema::hasColumn('courses', 'requirements')) {
                $table->json('requirements')->nullable()->after('objectives');
            }
        });

        // Ajouter icon à categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->default('fas fa-book')->after('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['duration', 'video_count', 'view_count', 'rating', 'order', 'objectives', 'requirements']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};