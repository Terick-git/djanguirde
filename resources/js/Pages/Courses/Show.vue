<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="djanguirde-header text-white shadow-lg">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="djanguirde-logo flex items-center space-x-3">
                        <Link href="/" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-dj-blue font-bold text-lg">D</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold">DJANGUIRDE</h1>
                                <p class="text-blue-100 text-xs">Learn without limits</p>
                            </div>
                        </Link>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="flex items-center space-x-8">
                        <Link href="/" class="hover:text-blue-200 transition font-medium">Accueil</Link>
                        <Link href="/courses" class="hover:text-blue-200 transition font-medium">Catalogue</Link>
                        <Link v-if="$page.props.auth.user" href="/dashboard" class="hover:text-blue-200 transition font-medium">Tableau de bord</Link>
                        <Link v-else href="/login" class="hover:text-blue-200 transition font-medium">Connexion</Link>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne de gauche - Contenu du cours -->
                <div class="lg:col-span-2">
                    <!-- En-tête du cours -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span 
                                class="text-sm font-semibold px-3 py-1 rounded-full text-white"
                                :style="{ backgroundColor: course.category.color }"
                            >
                                {{ course.category.name }}
                            </span>
                            <div class="flex items-center text-yellow-400">
                                <span>⭐⭐⭐⭐⭐</span>
                                <span class="text-gray-600 text-sm ml-2">4.8 (124 avis)</span>
                            </div>
                        </div>

                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ course.title }}</h1>
                        <p class="text-xl text-gray-600 mb-6">{{ course.short_description }}</p>

                        <div class="flex items-center space-x-6 text-gray-600 mb-6">
                            <div class="flex items-center">
                                <span class="mr-2">👨‍🏫</span>
                                <span>Par {{ course.instructor.name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2">📚</span>
                                <span>{{ course.lessons_count }} leçons</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2">⏱️</span>
                                <span>{{ getTotalDuration() }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2">👥</span>
                                <span>{{ course.enrollments_count }} étudiants</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <span 
                                class="px-3 py-1 rounded-full text-sm font-medium"
                                :class="{
                                    'bg-green-100 text-green-800': course.level === 'beginner',
                                    'bg-yellow-100 text-yellow-800': course.level === 'intermediate', 
                                    'bg-red-100 text-red-800': course.level === 'advanced'
                                }"
                            >
                                {{ getLevelText(course.level) }}
                            </span>
                            <span class="text-2xl font-bold text-dj-blue">
                                {{ course.price > 0 ? formatPrice(course.price) : 'Gratuit' }}
                            </span>
                        </div>
                    </div>

                    <!-- Description détaillée -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">📋 Description du cours</h2>
                        <div class="prose max-w-none text-gray-700">
                            <p>{{ course.description }}</p>
                        </div>
                    </div>

                    <!-- Programme du cours -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">🎯 Programme du cours</h2>
                        <div class="space-y-4">
                            <div 
                                v-for="(lesson, index) in course.lessons" 
                                :key="lesson.id"
                                class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="w-8 h-8 bg-dj-blue-light rounded-full flex items-center justify-center">
                                        <span class="text-dj-blue text-sm font-bold">{{ index + 1 }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ lesson.title }}</h3>
                                        <p class="text-sm text-gray-600">{{ lesson.duration }} min</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span 
                                        v-if="lesson.is_free"
                                        class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium"
                                    >
                                        Gratuit
                                    </span>
                                    <span class="text-gray-400">▶️</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite - Actions -->
                <div class="space-y-6">
                    <!-- Carte d'inscription -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-dj-blue mb-2">
                                {{ course.price > 0 ? formatPrice(course.price) : 'Gratuit' }}
                            </div>
                            <p class="text-gray-600">Accès à vie</p>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center text-gray-700">
                                <span class="mr-3 text-green-500">✓</span>
                                <span>Accès à toutes les leçons</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <span class="mr-3 text-green-500">✓</span>
                                <span>Certificat de completion</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <span class="mr-3 text-green-500">✓</span>
                                <span>Support de la communauté</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <span class="mr-3 text-green-500">✓</span>
                                <span>Accès sur mobile</span>
                            </div>
                        </div>

                        <button 
                            v-if="!hasEnrolled && !$page.props.auth.user"
                            @click="$inertia.visit('/register')"
                            class="w-full bg-dj-blue text-white py-4 rounded-xl font-semibold text-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl"
                        >
                            S'inscrire pour commencer
                        </button>

                        <button 
                            v-else-if="!hasEnrolled"
                            @click="enrollCourse"
                            class="w-full bg-dj-blue text-white py-4 rounded-xl font-semibold text-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl"
                        >
                            {{ course.price > 0 ? 'Acheter le cours' : 'Commencer le cours' }}
                        </button>

                        <Link 
                            v-else
                            :href="route('learning.course', course.slug)"
                            class="w-full bg-green-600 text-white py-4 rounded-xl font-semibold text-lg hover:bg-green-700 transition shadow-lg hover:shadow-xl block text-center"
                        >
                            Continuer l'apprentissage
                        </Link>

                        <p class="text-center text-gray-500 text-sm mt-4">
                            Garantie satisfait ou remboursé sous 30 jours
                        </p>
                    </div>

                    <!-- Instructeur -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">👨‍🏫 Votre formateur</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-dj-blue-light rounded-full flex items-center justify-center">
                                <span class="text-dj-blue font-bold text-xl">
                                    {{ getInitials(course.instructor.name) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ course.instructor.name }}</h4>
                                <p class="text-gray-600 text-sm">Expert en développement</p>
                                <p class="text-gray-500 text-xs">5 cours • 1243 étudiants</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cours similaires -->
            <section class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Cours similaires</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <CourseCard 
                        v-for="relatedCourse in relatedCourses" 
                        :key="relatedCourse.id" 
                        :course="relatedCourse" 
                    />
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import CourseCard from '@/Components/CourseCard.vue'

const props = defineProps({
    course: Object,
    hasEnrolled: Boolean,
    relatedCourses: Array
})

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price)
}

const getInitials = (name) => {
    if (!name) return '?'
    return name.split(' ').map(n => n[0]).join('').toUpperCase()
}

const getTotalDuration = () => {
    const totalMinutes = props.course.lessons.reduce((sum, lesson) => sum + (lesson.duration || 0), 0)
    const hours = Math.floor(totalMinutes / 60)
    const minutes = totalMinutes % 60
    return hours > 0 ? `${hours}h${minutes}min` : `${minutes}min`
}

const getLevelText = (level) => {
    const levels = {
        beginner: 'Débutant',
        intermediate: 'Intermédiaire', 
        advanced: 'Avancé'
    }
    return levels[level] || level
}

const enrollCourse = () => {
    // Logique d'inscription à implémenter
    alert('Fonctionnalité d\'inscription bientôt disponible!')
}
</script>