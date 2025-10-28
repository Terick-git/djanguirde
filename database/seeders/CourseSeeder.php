<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Vider les tables d'abord pour éviter les doublons
        Lesson::query()->delete();
        Course::query()->delete();
        
        $instructors = User::where('role', 'instructor')->get();
        $categories = Category::all();

        $courses = [
            // COLLÈGE - Mathématiques
            [
                'title' => 'Mathématiques 3ème - Préparation au Brevet',
                'description' => 'Maîtrisez tout le programme de maths de 3ème avec des exercices types Brevet corrigés. Pythagore, Thalès, fonctions, statistiques...',
                'short_description' => 'Tout le programme de maths 3ème et préparation Brevet',
                'price' => 49.99,
                'level' => 'collège',
                'category_id' => $categories->where('slug', 'mathematiques')->first()->id,
                'duration' => 540, // 9h
                'video_count' => 15,
                'view_count' => 2300,
                'rating' => 4.5,
                'order' => 1,
                'objectives' => ['Maîtriser le théorème de Pythagore', 'Comprendre les fonctions affines', 'Résoudre des équations'],
                'requirements' => ['Niveau 4ème en mathématiques', 'Calculatrice scientifique']
            ],
            [
                'title' => 'Français 4ème - Grammaire et Rédaction',
                'description' => 'Améliorez votre expression écrite et votre analyse de textes. Exercices pratiques et méthodes de rédaction.',
                'short_description' => 'Perfectionnement en grammaire et rédaction',
                'price' => 39.99,
                'level' => 'collège',
                'category_id' => $categories->where('slug', 'francais')->first()->id,
                'duration' => 480, // 8h
                'video_count' => 12,
                'view_count' => 1800,
                'rating' => 4.3,
                'order' => 2,
                'objectives' => ['Améliorer l\'orthographe', 'Maîtriser la conjugaison', 'Développer l\'expression écrite'],
                'requirements' => ['Bases de grammaire française', 'Niveau 5ème recommandé']
            ],

            // LYCÉE - Spécialités
            [
                'title' => 'Spécialité Mathématiques Terminale',
                'description' => 'Suites, fonctions, probabilités, géométrie. Préparation complète pour le Bac avec annales corrigées.',
                'short_description' => 'Spé Maths Terminale - Bac 2025',
                'price' => 69.99,
                'level' => 'lycée',
                'category_id' => $categories->where('slug', 'mathematiques')->first()->id,
                'duration' => 720, // 12h
                'video_count' => 20,
                'view_count' => 1500,
                'rating' => 4.7,
                'order' => 1,
                'objectives' => ['Maîtriser les limites de fonctions', 'Comprendre les suites numériques', 'Résoudre des problèmes de probabilités'],
                'requirements' => ['Niveau Première Spé Maths', 'Calculatrice graphique']
            ],
            [
                'title' => 'Physique-Chimie Terminale - Tout le programme',
                'description' => 'Mécanique, ondes, chimie organique. Cours complets avec manipulations virtuelles et exercices type Bac.',
                'short_description' => 'Physique-Chimie Terminale - Bac 2025',
                'price' => 59.99,
                'level' => 'lycée',
                'category_id' => $categories->where('slug', 'physique-chimie')->first()->id,
                'duration' => 600, // 10h
                'video_count' => 18,
                'view_count' => 1200,
                'rating' => 4.6,
                'order' => 2,
                'objectives' => ['Comprendre la mécanique newtonienne', 'Maîtriser la chimie organique', 'Analyser les phénomènes ondulatoires'],
                'requirements' => ['Niveau Première Physique-Chimie', 'Calculatrice scientifique']
            ],
            [
                'title' => 'Histoire-Géographie Terminale - Bac 2025',
                'description' => 'Révisions complètes pour le Bac : Histoire contemporaine, géographie des territoires, méthodologie des épreuves.',
                'short_description' => 'Histoire-Géo Terminale - Révisions Bac',
                'price' => 49.99,
                'level' => 'lycée',
                'category_id' => $categories->where('slug', 'histoire-geographie')->first()->id,
                'duration' => 480, // 8h
                'video_count' => 16,
                'view_count' => 900,
                'rating' => 4.4,
                'order' => 3,
                'objectives' => ['Analyser les grands enjeux du monde contemporain', 'Maîtriser la méthodologie de la dissertation', 'Comprendre la géopolitique actuelle'],
                'requirements' => ['Niveau Première Histoire-Géo', 'Culture générale']
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create([
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']),
                'description' => $courseData['description'],
                'short_description' => $courseData['short_description'],
                'price' => $courseData['price'],
                'level' => $courseData['level'],
                'status' => 'published',
                'instructor_id' => $instructors->random()->id,
                'category_id' => $courseData['category_id'],
                'duration' => $courseData['duration'],
                'video_count' => $courseData['video_count'],
                'view_count' => $courseData['view_count'],
                'rating' => $courseData['rating'],
                'order' => $courseData['order'],
                'objectives' => $courseData['objectives'],
                'requirements' => $courseData['requirements'],
            ]);

            // Créer des leçons adaptées au secondaire
            $lessons = [
                ['title' => 'Introduction et présentation du chapitre', 'duration' => 10, 'order' => 1, 'is_free' => true],
                ['title' => 'Cours théorique détaillé', 'duration' => 25, 'order' => 2, 'is_free' => true],
                ['title' => 'Méthodes et astuces', 'duration' => 20, 'order' => 3, 'is_free' => false],
                ['title' => 'Exercices d\'application', 'duration' => 30, 'order' => 4, 'is_free' => false],
                ['title' => 'Corrigés détaillés', 'duration' => 15, 'order' => 5, 'is_free' => false],
                ['title' => 'Annales et sujets type examen', 'duration' => 35, 'order' => 6, 'is_free' => false],
            ];

            foreach ($lessons as $index => $lessonData) {
                Lesson::create([
                    'title' => $lessonData['title'],
                    'content' => "Contenu pédagogique détaillé pour la leçon '{$lessonData['title']}'. Cette leçon couvre les concepts essentiels avec des exemples concrets adaptés aux élèves du secondaire.",
                    'video_url' => $this->getVideoUrl($index),
                    'video_type' => $this->getVideoType($this->getVideoUrl($index)),
                    'duration' => $lessonData['duration'],
                    'order' => $lessonData['order'],
                    'is_free' => $lessonData['is_free'],
                    'course_id' => $course->id,
                ]);
            }
        }
    }

    private function getVideoUrl(int $index): string
    {
        $videos = [
            'https://vimeo.com/1084537',
            'https://vimeo.com/139574099',
            'https://vimeo.com/22439234',
            'https://vimeo.com/106595658',
            'https://vimeo.com/371411541',
            'https://www.youtube.com/watch?v=KfS2t7lqMpY',
            'https://www.youtube.com/watch?v=WY-Z2l-7pUc',
            'https://www.youtube.com/watch?v=J6Tqo6k1g8c',
            'https://www.youtube.com/watch?v=6WlQ1Z-qg_c',
            'https://www.youtube.com/watch?v=4QivZzSqZ1w',
        ];

        return $videos[$index % count($videos)] ?? 'https://vimeo.com/1084537';
    }

    private function getVideoType(string $url): string
    {
        if (str_contains($url, 'vimeo.com')) {
            return 'vimeo';
        } elseif (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'youtube';
        } else {
            return 'external';
        }
    }
}