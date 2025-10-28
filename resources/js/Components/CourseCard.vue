<template>
    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-2 border-blue-100 hover:border-dj-blue">
        <!-- Image du cours -->
        <div class="h-48 bg-gradient-to-br from-dj-blue to-dj-blue-light relative overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-6xl text-white opacity-30">🎓</span>
            </div>
            <div class="absolute top-4 right-4">
                <span v-if="course.is_free" class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                    Gratuit
                </span>
                <span v-else class="bg-white text-dj-blue px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                    {{ formatPrice(course.price) }}
                </span>
            </div>
            <div class="absolute bottom-4 left-4">
                <span class="bg-white bg-opacity-90 text-dj-blue px-3 py-1 rounded-lg text-xs font-bold shadow-md">
                    {{ course.level }}
                </span>
            </div>
        </div>

        <!-- Contenu du cours -->
        <div class="p-6">
            <!-- Catégorie -->
            <div class="mb-3">
                <span 
                    class="text-xs font-semibold px-3 py-1.5 rounded-full text-white shadow-sm"
                    :style="{ backgroundColor: course.category?.color || '#2E5FE0' }"
                >
                    {{ course.category?.name || 'Non catégorisé' }}
                </span>
            </div>

            <!-- Titre -->
            <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-dj-blue transition-colors">
                {{ course.title }}
            </h3>

            <!-- Description -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                {{ course.short_description }}
            </p>

            <!-- Instructeur -->
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-dj-blue to-dj-blue-light rounded-full flex items-center justify-center mr-3 shadow-md">
                    <span class="text-white text-xs font-bold">
                        {{ getInitials(course.instructor?.name) }}
                    </span>
                </div>
                <span class="text-gray-700 text-sm font-medium">
                    {{ course.instructor?.name || 'Instructeur' }}
                </span>
            </div>

            <!-- Métriques -->
            <div class="flex items-center justify-between text-sm text-gray-500 border-t border-blue-100 pt-4">
                <div class="flex items-center bg-blue-50 px-3 py-1.5 rounded-lg">
                    <span class="mr-2 text-dj-blue">📚</span>
                    <span class="font-semibold text-dj-blue">{{ course.lessons_count || 0 }} leçons</span>
                </div>
                <div class="flex items-center bg-blue-50 px-3 py-1.5 rounded-lg">
                    <span class="mr-2 text-dj-blue">👥</span>
                    <span class="font-semibold text-dj-blue">{{ course.enrollments_count || 0 }} étudiants</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-4">
                <a 
                    :href="`/courses/${course.slug}`"
                    class="block w-full bg-gradient-to-r from-dj-blue to-dj-blue-light text-white text-center py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-600 transition transform hover:scale-105 shadow-md"
                >
                    Voir le cours →
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    course: {
        type: Object,
        required: true
    }
})

const formatPrice = (price) => {
    if (!price) return 'Gratuit'
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price)
}

const getInitials = (name) => {
    if (!name) return '?'
    return name.split(' ').map(n => n[0]).join('').toUpperCase()
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