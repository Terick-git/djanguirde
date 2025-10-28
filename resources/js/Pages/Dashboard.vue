<template>
    <AppLayout>
        <!-- Dashboard Content -->
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Welcome Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-blue-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold text-gray-900 mb-3">
                                Bonjour, {{ $page.props.auth.user.name }} ! 👋
                            </h1>
                            <p class="text-lg text-gray-600 mb-4">
                                Bienvenue sur votre espace d'apprentissage personnalisé
                            </p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Niveau: Seconde
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Compte actif
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 lg:mt-0 lg:ml-8">
                            <div class="bg-gradient-to-r from-[#7CBCF8] to-blue-500 text-white px-6 py-4 rounded-xl text-center">
                                <p class="text-sm opacity-90">Streak actuel</p>
                                <p class="text-2xl font-bold">7 jours 🔥</p>
                                <p class="text-xs mt-1 opacity-80">Continue comme ça !</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Progress -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- My Courses Section -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                    <span class="mr-3">📚</span>
                                    Mes cours en cours
                                </h2>
                                <Link href="/courses" class="text-[#7CBCF8] hover:text-blue-700 font-semibold text-sm">
                                    Voir tous les cours →
                                </Link>
                            </div>
                            
                            <div class="space-y-4">
                                <div v-for="course in enrolledCourses" :key="course.id" 
                                    class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border-2 border-blue-100 rounded-xl hover:border-[#7CBCF8] hover:shadow-md transition-all bg-gradient-to-r from-white to-blue-50">
                                    <div class="flex items-center space-x-4 flex-1 mb-3 sm:mb-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-[#7CBCF8] to-blue-500 rounded-xl flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-lg">{{ course.title.charAt(0) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-1">{{ course.title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                                <span class="font-semibold text-[#7CBCF8]">Progression: {{ course.pivot.progress || 0 }}%</span>
                                                <span>•</span>
                                                <span>{{ getCompletedLessons(course) }}/{{ course.lessons_count }} leçons</span>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="w-full bg-gray-200 rounded-full h-3">
                                                <div class="bg-gradient-to-r from-[#7CBCF8] to-blue-500 h-3 rounded-full transition-all duration-500 shadow-sm"
                                                    :style="{ width: (course.pivot.progress || 0) + '%' }"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <Link 
                                        :href="route('learning.course', course.slug)"
                                        class="bg-gradient-to-r from-[#7CBCF8] to-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition transform hover:scale-105 shadow-md w-full sm:w-auto text-center"
                                    >
                                        {{ course.pivot.progress > 0 ? 'Continuer' : 'Commencer' }}
                                    </Link>
                                </div>

                                <div v-if="enrolledCourses.length === 0" class="text-center py-12 bg-blue-50 rounded-xl border-2 border-dashed border-blue-300">
                                    <div class="text-6xl mb-4">📚</div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun cours suivi</h3>
                                    <p class="text-gray-600 mb-6">Commence ton apprentissage dès maintenant</p>
                                    <Link href="/courses" class="inline-block bg-gradient-to-r from-[#7CBCF8] to-blue-500 text-white px-8 py-4 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition transform hover:scale-105 shadow-lg">
                                        Découvrir les cours
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendations -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span class="mr-3">💡</span>
                                Recommandé pour toi
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div v-for="course in recommendedCourses" :key="course.id" 
                                    class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-shadow bg-white">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-[#7CBCF8] to-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-sm">{{ course.title.charAt(0) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 mb-2">{{ course.title }}</h4>
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ course.description }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-500">{{ course.lessons_count }} leçons</span>
                                                <Link 
                                                    :href="route('courses.show', course.slug)"
                                                    class="text-[#7CBCF8] hover:text-blue-700 font-semibold text-sm"
                                                >
                                                    Voir le cours →
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Stats & Actions -->
                    <div class="space-y-6">
                        <!-- Statistics -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">📊</span>
                                Mes statistiques
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                    <span class="text-gray-600">Cours suivis</span>
                                    <span class="font-semibold text-[#7CBCF8] text-xl">{{ enrolledCourses.length }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                    <span class="text-gray-600">Leçons terminées</span>
                                    <span class="font-semibold text-[#7CBCF8] text-xl">12</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                    <span class="text-gray-600">Temps d'étude</span>
                                    <span class="font-semibold text-[#7CBCF8] text-xl">8h 30min</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                    <span class="text-gray-600">Progression moyenne</span>
                                    <span class="font-semibold text-[#7CBCF8] text-xl">45%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Goals -->
                        <div class="bg-gradient-to-br from-[#7CBCF8] to-blue-500 text-white rounded-2xl shadow-lg p-6">
                            <h3 class="font-bold mb-4 flex items-center">
                                <span class="mr-2">🎯</span>
                                Objectif du jour
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="mr-3">✓</span>
                                    <span>1 leçon de mathématiques</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-3">✓</span>
                                    <span>Exercices de français</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-3">○</span>
                                    <span>Révision physique</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">⚡</span>
                                Actions rapides
                            </h3>
                            <div class="space-y-3">
                                <Link href="/exercices" class="w-full bg-gradient-to-r from-[#7CBCF8] to-blue-500 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition transform hover:scale-105 block text-center shadow-md">
                                    📝 Faire des exercices
                                </Link>
                                <Link href="/annales" class="w-full bg-white border-2 border-[#7CBCF8] text-[#7CBCF8] py-3 rounded-lg font-semibold hover:bg-blue-50 transition block text-center">
                                    📚 Voir les annales
                                </Link>
                                <Link href="/planning" class="w-full bg-white border-2 border-[#7CBCF8] text-[#7CBCF8] py-3 rounded-lg font-semibold hover:bg-blue-50 transition block text-center">
                                    📅 Mon planning
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    enrolledCourses: Array,
    recommendedCourses: Array,
    stats: Object
})

// Method to calculate completed lessons
const getCompletedLessons = (course) => {
    return Math.floor((course.lessons_count * (course.pivot.progress || 0)) / 100)
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>