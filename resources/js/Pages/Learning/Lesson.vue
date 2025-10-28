<template>
    <div class="min-h-screen bg-gray-900 text-white">
        <!-- Header fixe -->
        <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <Link :href="route('learning.course', course.slug)" 
                              class="text-blue-400 hover:text-blue-300 transition flex items-center space-x-2">
                            <span>←</span>
                            <span>Retour au cours</span>
                        </Link>
                        <div class="h-6 w-px bg-gray-600"></div>
                        <h1 class="text-lg font-semibold truncate max-w-md">{{ course.title }}</h1>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Progression -->
                        <div class="text-sm">
                            <span class="text-gray-400">Leçon</span>
                            <span class="font-semibold ml-1">{{ currentIndex + 1 }}/{{ totalLessons }}</span>
                        </div>
                        
                        <!-- Navigation -->
                        <div class="flex items-center space-x-3">
                            <Link v-if="previousLesson" 
                                  :href="route('learning.lesson', { course: course.slug, lesson: previousLesson.id })"
                                  class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg transition flex items-center space-x-2">
                                <span>←</span>
                                <span class="hidden sm:block">Précédent</span>
                            </Link>
                            
                            <Link v-if="nextLesson"
                                  :href="route('learning.lesson', { course: course.slug, lesson: nextLesson.id })"
                                  class="bg-dj-blue hover:bg-blue-600 px-4 py-2 rounded-lg transition flex items-center space-x-2">
                                <span class="hidden sm:block">Suivant</span>
                                <span>→</span>
                            </Link>
                            <button v-else
                                    @click="completeCourse"
                                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition font-semibold">
                                Terminer le cours 🎓
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Barre de progression -->
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-400 mb-2">
                        <span>Progression de la leçon</span>
                        <span>{{ Math.round((currentIndex + 1) / totalLessons * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-dj-blue h-2 rounded-full transition-all duration-500"
                             :style="{ width: ((currentIndex + 1) / totalLessons * 100) + '%' }"></div>
                    </div>
                </div>
            </div>
        </header>

        <main class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Sidebar - Programme -->
                <div class="xl:col-span-1">
                    <div class="bg-gray-800 rounded-2xl p-6 sticky top-32">
                        <h3 class="font-bold text-lg mb-4 flex items-center">
                            <span class="mr-2">📚</span>
                            Programme
                        </h3>
                        
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <Link
                                v-for="(lessonItem, index) in course.lessons"
                                :key="lessonItem.id"
                                :href="route('learning.lesson', { course: course.slug, lesson: lessonItem.id })"
                                class="flex items-center space-x-3 p-3 rounded-lg border transition"
                                :class="{
                                    'border-dj-blue bg-blue-900 bg-opacity-20': lesson.id === lessonItem.id,
                                    'border-green-600 bg-green-900 bg-opacity-20': completedLessons.includes(lessonItem.id),
                                    'border-gray-600 hover:border-gray-500': lesson.id !== lessonItem.id && !completedLessons.includes(lessonItem.id)
                                }"
                            >
                                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium border"
                                    :class="{
                                        'bg-dj-blue border-dj-blue text-white': lesson.id === lessonItem.id,
                                        'bg-green-600 border-green-600 text-white': completedLessons.includes(lessonItem.id),
                                        'bg-gray-700 border-gray-600 text-gray-300': lesson.id !== lessonItem.id && !completedLessons.includes(lessonItem.id)
                                    }">
                                    {{ index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate" 
                                       :class="{
                                           'text-white': lesson.id === lessonItem.id,
                                           'text-gray-300': lesson.id !== lessonItem.id
                                       }">
                                        {{ lessonItem.title }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ lessonItem.duration }} min</p>
                                </div>
                                <div v-if="completedLessons.includes(lessonItem.id)" 
                                     class="text-green-400 text-lg">✓</div>
                            </Link>
                        </div>

                        <!-- Stats rapides -->
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-green-400">{{ completedLessons.length }}</div>
                                    <div class="text-xs text-gray-400">Terminées</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-dj-blue">{{ totalLessons - completedLessons.length }}</div>
                                    <div class="text-xs text-gray-400">Restantes</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="xl:col-span-3">
                    <div class="bg-gray-800 rounded-2xl overflow-hidden">
                        <!-- En-tête de la leçon -->
                        <div class="bg-gradient-to-r from-dj-blue to-blue-600 px-8 py-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                                            Leçon {{ currentIndex + 1 }} sur {{ totalLessons }}
                                        </span>
                                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                                            ⏱️ {{ lesson.duration }} minutes
                                        </span>
                                        <span v-if="lesson.is_free" 
                                              class="bg-green-500 px-3 py-1 rounded-full text-sm">
                                            Gratuit
                                        </span>
                                    </div>
                                    <h2 class="text-3xl font-bold mb-2">{{ lesson.title }}</h2>
                                    <p class="text-blue-100 text-lg opacity-90">{{ course.title }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <button v-if="!completedLessons.includes(lesson.id)"
                                            @click="markAsCompleted"
                                            class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition flex items-center space-x-2">
                                        <span>✓</span>
                                        <span>Marquer comme terminée</span>
                                    </button>
                                    <div v-else 
                                         class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold flex items-center space-x-2">
                                        <span>🎉</span>
                                        <span>Leçon terminée !</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Player Vidéo -->
                        <div class="p-8">
                            <VideoPlayer 
                                :lesson="lesson"
                                :video-url="lesson.video_url"
                            />

                            <!-- Contenu texte -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                                <!-- Contenu principal -->
                                <div class="lg:col-span-2">
                                    <div class="bg-gray-700 rounded-2xl p-6">
                                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                                            <span class="mr-3">📖</span>
                                            Contenu de la leçon
                                        </h3>
                                        
                                        <div class="prose prose-invert max-w-none">
                                            <div class="text-gray-200 leading-relaxed space-y-4">
                                                <p class="text-lg">{{ lesson.content }}</p>
                                                
                                                <!-- Exemple de contenu enrichi -->
                                                <div class="bg-gray-600 rounded-lg p-4 my-6">
                                                    <h4 class="font-bold text-white mb-3">💡 À retenir :</h4>
                                                    <ul class="space-y-2 text-blue-200">
                                                        <li class="flex items-start">
                                                            <span class="mr-2 mt-1">•</span>
                                                            <span>Point clé important de cette leçon</span>
                                                        </li>
                                                        <li class="flex items-start">
                                                            <span class="mr-2 mt-1">•</span>
                                                            <span>Deuxième élément essentiel à mémoriser</span>
                                                        </li>
                                                        <li class="flex items-start">
                                                            <span class="mr-2 mt-1">•</span>
                                                            <span>Conseil pratique pour la mise en œuvre</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Exercice pratique -->
                                                <div class="bg-blue-900 bg-opacity-20 border border-blue-700 rounded-lg p-6 my-6">
                                                    <h4 class="font-bold text-blue-300 mb-3 flex items-center">
                                                        <span class="mr-2">✏️</span>
                                                        Exercice pratique
                                                    </h4>
                                                    <p class="text-blue-200 mb-4">
                                                        Maintenant que vous avez vu la théorie, essayez de résoudre cet exercice :
                                                    </p>
                                                    <div class="bg-gray-800 rounded p-4 mb-4">
                                                        <p class="text-gray-300 italic">
                                                            "Appliquez les concepts vus dans cette leçon pour résoudre un problème similaire à ceux rencontrés en examen."
                                                        </p>
                                                    </div>
                                                    <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded transition text-sm">
                                                        Voir la correction
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sidebar droite -->
                                <div class="space-y-6">
                                    <!-- Objectifs -->
                                    <div class="bg-gradient-to-br from-blue-900 to-purple-900 rounded-2xl p-6">
                                        <h4 class="font-bold text-white mb-4 flex items-center">
                                            <span class="mr-2">🎯</span>
                                            Objectifs
                                        </h4>
                                        <ul class="space-y-3 text-blue-100">
                                            <li class="flex items-center">
                                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 text-white text-sm">✓</span>
                                                <span>Comprendre les concepts fondamentaux</span>
                                            </li>
                                            <li class="flex items-center">
                                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 text-white text-sm">✓</span>
                                                <span>Maîtriser la méthodologie</span>
                                            </li>
                                            <li class="flex items-center">
                                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 text-white text-sm">✓</span>
                                                <span>Être capable de résoudre les exercices</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Ressources -->
                                    <div class="bg-gray-700 rounded-2xl p-6">
                                        <h4 class="font-bold text-white mb-4 flex items-center">
                                            <span class="mr-2">📎</span>
                                            Ressources
                                        </h4>
                                        <div class="space-y-3">
                                            <button class="w-full bg-gray-600 hover:bg-gray-500 p-3 rounded-lg transition text-left flex items-center space-x-3">
                                                <span class="text-2xl">📄</span>
                                                <div>
                                                    <div class="font-medium text-white">PDF du cours</div>
                                                    <div class="text-sm text-gray-400">Télécharger</div>
                                                </div>
                                            </button>
                                            <button class="w-full bg-gray-600 hover:bg-gray-500 p-3 rounded-lg transition text-left flex items-center space-x-3">
                                                <span class="text-2xl">📝</span>
                                                <div>
                                                    <div class="font-medium text-white">Exercices</div>
                                                    <div class="text-sm text-gray-400">PDF - 12 exercices</div>
                                                </div>
                                            </button>
                                            <button class="w-full bg-gray-600 hover:bg-gray-500 p-3 rounded-lg transition text-left flex items-center space-x-3">
                                                <span class="text-2xl">🎯</span>
                                                <div>
                                                    <div class="font-medium text-white">Fiche de révision</div>
                                                    <div class="text-sm text-gray-400">Résumé du chapitre</div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Prochaines étapes -->
                                    <div class="bg-gray-700 rounded-2xl p-6">
                                        <h4 class="font-bold text-white mb-4">➡️ Prochaines étapes</h4>
                                        <div v-if="nextLesson" class="space-y-3">
                                            <Link :href="route('learning.lesson', { course: course.slug, lesson: nextLesson.id })"
                                                  class="block bg-dj-blue hover:bg-blue-600 p-4 rounded-lg transition group">
                                                <div class="font-semibold text-white group-hover:underline">
                                                    {{ nextLesson.title }}
                                                </div>
                                                <div class="text-sm text-blue-200 mt-1">
                                                    Leçon {{ currentIndex + 2 }} • {{ nextLesson.duration }} min
                                                </div>
                                            </Link>
                                        </div>
                                        <div v-else class="text-center py-4">
                                            <div class="text-3xl mb-2">🎓</div>
                                            <div class="font-semibold text-green-400">Félicitations !</div>
                                            <div class="text-sm text-gray-400 mt-1">Vous avez terminé ce cours</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import VideoPlayer from '@/Components/VideoPlayer.vue'

const props = defineProps({
    course: Object,
    lesson: Object,
    enrollment: Object,
    completedLessons: Array,
    previousLesson: Object,
    nextLesson: Object,
    currentIndex: Number,
    totalLessons: Number
})

const markAsCompleted = async () => {
    try {
        const response = await fetch(`/learning/${props.course.slug}/complete-lesson/${props.lesson.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            router.reload()
        }
    } catch (error) {
        console.error('Erreur:', error)
    }
}

const completeCourse = () => {
    router.visit(route('learning.course', props.course.slug))
}
</script>

<style scoped>
.prose-invert {
    color: inherit;
}

.prose-invert h1,
.prose-invert h2,
.prose-invert h3,
.prose-invert h4 {
    color: white;
}
</style>