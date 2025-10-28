<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Matières principales
            ['name' => 'Mathématiques', 'slug' => 'mathematiques', 'color' => '#2E5FE0'],
            ['name' => 'Français', 'slug' => 'francais', 'color' => '#7CBCF8'],
            ['name' => 'Physique-Chimie', 'slug' => 'physique-chimie', 'color' => '#10B981'],
            ['name' => 'SVT', 'slug' => 'svt', 'color' => '#F59E0B'],
            ['name' => 'Histoire-Géographie', 'slug' => 'histoire-geographie', 'color' => '#EF4444'],
            ['name' => 'Anglais', 'slug' => 'anglais', 'color' => '#8B5CF6'],
            ['name' => 'Espagnol', 'slug' => 'espagnol', 'color' => '#EC4899'],
            ['name' => 'Philosophie', 'slug' => 'philosophie', 'color' => '#6366F1'],
            
            // Spécialités Lycée
            ['name' => 'SES', 'slug' => 'ses', 'color' => '#84CC16'],
            ['name' => 'NSI', 'slug' => 'nsi', 'color' => '#F97316'],
            ['name' => 'HLP', 'slug' => 'hlp', 'color' => '#06B6D4'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}