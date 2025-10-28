<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <Link href="/dashboard" class="text-dj-blue hover:text-blue-700 transition">
                            ← Retour au tableau de bord
                        </Link>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <h1 class="text-xl font-bold text-gray-900">{{ course.title }}</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            Progression: <span class="font-semibold">{{ Math.round(enrollment.progress) }}%</span>
                        </div>
                        <Link href="/courses" class="text-gray-600 hover:text-gray-900 transition">
                            📚 Catalogue
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar - Programme -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Programme du cours</h2>
                        
                        <!-- Progression -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Progression globale</span>
                                <span>{{ Math.round(enrollment.progress) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div 
                                    class="bg-dj-blue h-2 rounded-full transition-all duration-500"
                                    :style="{ width: enrollment.progress + '%' }"
                                ></div>
                            </div>
                        </div>

                        <!-- Liste des leçons -->
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <div
                                v-for="(lesson, index) in course.lessons"
                                :key="lesson.id"
                                class="flex items-center space-x-3 p-3 rounded-lg border transition cursor-pointer"
                                :class="{
                                    'border-dj-blue bg-blue-50': currentLesson?.id === lesson.id,
                                    'border-green-200 bg-green-50': completedLessons.includes(lesson.id),
                                    'border-gray-200 hover:border-gray-300': currentLesson?.id !== lesson.id && !completedLessons.includes(lesson.id)
                                }"
                                @click="selectLesson(lesson)"
                            >
                                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                                    :class="{
                                        'bg-dj-blue text-white': currentLesson?.id === lesson.id,
                                        'bg-green-500 text-white': completedLessons.includes(lesson.id),
                                        'bg-gray-200 text-gray-600': currentLesson?.id !== lesson.id && !completedLessons.includes(lesson.id)
                                    }">
                                    {{ index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ lesson.title }}</p>
                                    <p class="text-xs text-gray-500">{{ lesson.duration }} min</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span v-if="completedLessons.includes(lesson.id)" class="text-green-500">✓</span>
                                    <span v-else-if="lesson.is_free" class="text-blue-500 text-xs">Gratuit</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats rapides -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-dj-blue">{{ completedLessons.length }}</div>
                                    <div class="text-xs text-gray-600">Leçons terminées</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-green-600">{{ course.lessons.length - completedLessons.length }}</div>
                                    <div class="text-xs text-gray-600">Restantes</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- En-tête de la leçon -->
                        <div class="bg-gradient-to-r from-dj-blue to-dj-blue-light px-6 py-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold mb-2">{{ currentLesson.title }}</h2>
                                    <p class="text-blue-100 opacity-90">
                                        Leçon {{ getLessonNumber(currentLesson) }} sur {{ course.lessons.length }} • 
                                        {{ currentLesson.duration }} minutes
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div v-if="completedLessons.includes(currentLesson.id)" 
                                         class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        ✓ Terminée
                                    </div>
                                    <button v-else
                                            @click="markAsCompleted"
                                            class="bg-white text-dj-blue px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">
                                        Marquer comme terminée
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Contenu de la leçon -->
                        <div class="p-8">
                            <!-- Player vidéo (simulé) -->
                            <div class="mb-8">
                                <div class="bg-gray-900 rounded-xl aspect-video flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-purple-900 opacity-80"></div>
                                    <div class="relative z-10 text-center text-white">
                                        <div class="text-6xl mb-4">🎬</div>
                                        <p class="text-xl font-semibold">Vidéo de la leçon</p>
                                        <p class="text-blue-200 mt-2">Lecture simulée - Durée: {{ currentLesson.duration }}min</p>
                                        
                                        <!-- Contrôles de lecture simulés -->
                                        <div class="mt-6 flex justify-center space-x-4">
                                            <button class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                                                ⏮️
                                            </button>
                                            <button class="w-16 h-16 bg-dj-blue rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                                ▶️
                                            </button>
                                            <button class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                                                ⏭️
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenu texte -->
                            <div class="prose max-w-none">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Contenu de la leçon</h3>
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <p class="text-gray-700 leading-relaxed">{{ currentLesson.content }}</p>
                                </div>

                                <!-- Objectifs d'apprentissage -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                                    <h4 class="font-bold text-blue-900 mb-3 flex items-center">
                                        <span class="mr-2">🎯</span>
                                        Objectifs de cette leçon
                                    </h4>
                                    <ul class="text-blue-800 space-y-2">
                                        <li class="flex items-center">
                                            <span class="mr-2">✓</span>
                                            Comprendre les concepts clés
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">✓</span>
                                            Maîtriser la méthodologie
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">✓</span>
                                            Être capable de refaire les exercices
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Navigation entre les leçons -->
                            <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                                <button 
                                    v-if="getPreviousLesson(currentLesson)"
                                    @click="selectLesson(getPreviousLesson(currentLesson))"
                                    class="flex items-center space-x-2 text-dj-blue hover:text-blue-700 transition font-semibold">
                                    <span>←</span>
                                    <span>Leçon précédente</span>
                                </button>
                                <div v-else></div>

                                <button 
                                    v-if="getNextLesson(currentLesson)"
                                    @click="selectLesson(getNextLesson(currentLesson))"
                                    class="flex items-center space-x-2 bg-dj-blue text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                    <span>Leçon suivante</span>
                                    <span>→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    course: Object,
    enrollment: Object,
    completedLessons: Array,
    currentLesson: Object
})

const currentLesson = ref(props.currentLesson)

const getLessonNumber = (lesson) => {
    return props.course.lessons.findIndex(l => l.id === lesson.id) + 1
}

const getPreviousLesson = (lesson) => {
    const index = props.course.lessons.findIndex(l => l.id === lesson.id)
    return index > 0 ? props.course.lessons[index - 1] : null
}

const getNextLesson = (lesson) => {
    const index = props.course.lessons.findIndex(l => l.id === lesson.id)
    return index < props.course.lessons.length - 1 ? props.course.lessons[index + 1] : null
}

const selectLesson = (lesson) => {
    currentLesson.value = lesson
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

const markAsCompleted = async () => {
    try {
        const response = await fetch(`/learning/${props.course.slug}/complete-lesson/${currentLesson.value.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            const data = await response.json()
            // Recharger la page pour mettre à jour les données
            router.reload()
        }
    } catch (error) {
        console.error('Erreur:', error)
    }
}
</script>