<template>
    <AppLayout>
        <!-- Header avec recherche -->
        <header class="main-header">
            <div class="header-content">
                <div class="title-search-container">
                    <h1 class="page-title" style="color: black;">               Course</h1>
                    <div class="search-filter-container">
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input 
                                type="text" 
                                placeholder="Rechercher un cours..."
                                v-model="filters.search"
                                @input="performSearch"
                            >
                        </div>
                        <button class="filter-btn" @click="toggleFilters">
                            <i class="fas fa-filter"></i>
                            Filtres
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Filtres -->
        <div v-if="showFilters" class="filters-panel">
            <div class="filters-content">
                <div class="filter-options">
                    <div class="filter-group">
                        <label>Catégorie</label>
                        <select v-model="filters.category" @change="applyFilters">
                            <option value="">Toutes les catégories</option>
                            <option 
                                v-for="category in categories" 
                                :key="category.id" 
                                :value="category.slug"
                            >
                                {{ category.name }} ({{ category.courses_count }})
                            </option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Niveau</label>
                        <select v-model="filters.level" @change="applyFilters">
                            <option value="">Tous les niveaux</option>
                            <option value="collège">Collège</option>
                            <option value="lycée">Lycée</option>
                            <option value="beginner">Débutant</option>
                            <option value="intermediate">Intermédiaire</option>
                            <option value="advanced">Avancé</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="container">
            <!-- Groupement par catégorie -->
            <template v-for="category in groupedCourses" :key="category.id">
                <section class="course-category-section" v-if="category.courses.length > 0">
                    
                    <!-- 1. EN-TÊTE DE SECTION (Titre et Description) -->
                    <div class="section-header-main">
                        <div class="section-title-content">
                            <h2 class="section-main-title">
                                {{ category.name }}
                            </h2>
                            <p class="section-slogan">
                                {{ category.description || getCategorySlogan(category.name) }}
                            </p>
                        </div>
                        <div class="section-actions" v-if="category.courses.length > 3">
                            <button class="view-all-btn">
                                Voir tout
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- 2. GRILLE DES CARTES (Contenu) -->
                    <div class="courses-grid-section">
                        <div 
                            v-for="course in category.courses.slice(0, 3)" 
                            :key="course.id"
                            class="course-card"
                        >
                            <!-- Zone Supérieure : Image et Badge -->
                            <div class="course-image-container">
                                <img 
                                    :src="`/images/img${(course.id % 8) + 1}.jpg`" 
                                    :alt="course.title"
                                    class="course-thumbnail"
                                >
                                <div class="video-badge">
                                    {{ course.video_count }}+ vidéos
                                </div>
                            </div>

                            <!-- Zone Intermédiaire : Métadonnées -->
                            <div class="course-meta">
                                <!-- Ligne des Statistiques -->
                                <div class="stats-row">
                                    <div class="stat views">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ course.formatted_views || '2,3 k' }} vues</span>
                                    </div>
                                    <div class="stat duration">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ course.formatted_duration || '9h 32min' }}</span>
                                    </div>
                                </div>

                                <!-- Ligne d'Identification et Note -->
                                <div class="title-rating-row">
                                    <div class="course-identity">
                                        <h3 class="course-main-title">{{ course.title }}</h3>
                                        <p class="course-subtitle">{{ getCategorySubtitle(category.name) }}</p>
                                    </div>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <span>{{ course.rating || '4.5' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Zone Inférieure : Actions -->
                            <div class="course-actions">
                                <button class="like-btn">
                                    <i class="fas fa-heart"></i>
                                    Like
                                </button>
                                <Link 
                                    :href="`/courses/${course.slug}`" 
                                    class="start-btn"
                                >
                                    Start
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton "Voir plus" pour les sections avec plus de 3 cours -->
                    <div class="section-footer" v-if="category.courses.length > 3">
                        <button class="load-more-btn">
                            Voir les {{ category.courses.length - 3 }} cours supplémentaires
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </section>
            </template>

            <!-- Message si aucun cours -->
            <div v-if="courses.length === 0" class="no-courses">
                <i class="fas fa-search fa-3x"></i>
                <h3>Aucun cours trouvé</h3>
                <p>Aucun cours ne correspond à vos critères de recherche.</p>
                <button @click="resetFilters" class="btn-reset">
                    Réinitialiser les filtres
                </button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { debounce } from 'lodash'
import AppLayout from '@/Layouts/AppLayout.vue'

// Props from Laravel controller
const props = defineProps({
    courses: Array,
    categories: Array,
    filters: Object
})

// Reactive data
const showFilters = ref(false)
const filters = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    level: props.filters.level || ''
})

// Computed: Group courses by category
const groupedCourses = computed(() => {
    const grouped = {}
    
    props.courses.forEach(course => {
        if (!grouped[course.category.id]) {
            grouped[course.category.id] = {
                ...course.category,
                courses: []
            }
        }
        grouped[course.category.id].courses.push(course)
    })
    
    return Object.values(grouped)
})

// Helper functions pour les textes des sections
const getCategorySlogan = (categoryName) => {
    const slogans = {
        'Mathématiques': 'Maîtrisez les concepts mathématiques avec nos cours experts',
        'Physique': 'Découvrez les lois de l\'univers et leurs applications',
        'Chimie': 'Explorez la composition de la matière et ses transformations',
        'Informatique': 'Développez vos compétences numériques et de programmation',
        'Anglais': 'Améliorez votre communication en anglais dans tous les contextes',
        'Français': 'Perfectionnez votre expression écrite et orale en français',
        'Histoire': 'Plongez dans les grandes civilisations et événements historiques',
        'Géographie': 'Comprenez les territoires et les enjeux sociétaux',
        'Philosophie': 'Développez votre esprit critique et votre réflexion',
        'SVT': 'Explorez le vivant et les sciences de la nature'
    };
    
    return slogans[categoryName] || 'Découvrez nos cours spécialisés pour progresser';
}

const getCategorySubtitle = (categoryName) => {
    const subtitles = {
        'Mathématiques': 'Calcul et analyse avancée',
        'Physique': 'Science de la matière et énergie',
        'Chimie': 'Composition et propriétés',
        'Informatique': 'Programmation et algorithmes',
        'Anglais': 'Communication et grammaire',
        'Français': 'Littérature et expression',
        'Histoire': 'Civilisations et événements',
        'Géographie': 'Territoires et sociétés',
        'Philosophie': 'Réflexion et pensée critique',
        'SVT': 'Biologie et sciences naturelles'
    };
    
    return subtitles[categoryName] || 'Cours spécialisé';
}

// Debounced search avec lodash
const performSearch = debounce(() => {
    applyFilters()
}, 500)

// Apply all filters
const applyFilters = () => {
    const params = new URLSearchParams()
    if (filters.value.search) params.append('search', filters.value.search)
    if (filters.value.category) params.append('category', filters.value.category)
    if (filters.value.level) params.append('level', filters.value.level)
    
    const queryString = params.toString()
    const url = queryString ? `/courses?${queryString}` : '/courses'
    
    router.get(url, {}, {
        preserveState: true,
        replace: true
    })
}

// Reset filters
const resetFilters = () => {
    filters.value = { search: '', category: '', level: '' }
    applyFilters()
}

// Toggle filters panel
const toggleFilters = () => {
    showFilters.value = !showFilters.value
}
</script>

<style scoped>
/* Header avec fond bleu clair et texte noir */
.main-header {
    background: #7CBCF8;
    color: black;
    padding: 20px 32px;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
}

/* Nouveau conteneur pour titre + recherche */
.title-search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    color: black;
    margin: 0;
    white-space: nowrap;
}

.search-filter-container {
    display: flex;
    gap: 16px;
    align-items: center;
    flex-shrink: 0;
}

/* Barre de recherche avec texte noir */
.search-bar {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    padding: 8px 16px;
    backdrop-filter: blur(10px);
    min-width: 300px;
}

.search-bar i {
    color: #4a5568;
    margin-right: 10px;
}

.search-bar input {
    background: transparent;
    border: none;
    outline: none;
    color: #2d3748;
    font-size: 15px;
    width: 100%;
}

.search-bar input::placeholder {
    color: #718096;
}

.filter-btn {
    background: white;
    border: none;
    color: #3498db;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    white-space: nowrap;
}

.filter-btn:hover {
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Panel des filtres */
.filters-panel {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 20px 0;
}

.filters-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
}

.filter-options {
    display: flex;
    gap: 30px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group label {
    font-weight: 600;
    color: #475569;
    font-size: 14px;
}

.filter-group select {
    padding: 8px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background: white;
    font-size: 14px;
}

/* Contenu principal */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 32px;
}

/* STRUCTURE DES SECTIONS DE COURS - ESPACES TRÈS RÉDUITS */
.course-category-section {
    margin-bottom: 20px;
    padding: 15px 0;
}

.course-category-section:last-child {
    margin-bottom: 0;
}

/* 1. EN-TÊTE DE SECTION - ESPACES MINIMUM */
.section-header-main {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 15px;
    padding: 0 5px;
}

.section-title-content {
    flex: 1;
}

.section-main-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1a202c;
    margin: 0 0 5px 0;
    line-height: 1.1;
    background: linear-gradient(135deg, #1a202c, #2d3748);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-slogan {
    font-size: 1rem;
    color: #64748b;
    margin: 0;
    line-height: 1.3;
    max-width: 600px;
}

.section-actions {
    flex-shrink: 0;
}

.view-all-btn {
    background: transparent;
    border: 2px solid #3498db;
    color: #3498db;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
}

.view-all-btn:hover {
    background: #3498db;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

/* 2. GRILLE DES CARTES - ESPACES RÉDUITS */
.courses-grid-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 5px;
}

.course-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
}

/* 1. Zone Supérieure : Image et Badge */
.course-image-container {
    position: relative;
    height: 160px;
    overflow: hidden;
}

.course-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-card:hover .course-thumbnail {
    transform: scale(1.05);
}

.video-badge {
    position: absolute;
    bottom: 8px;
    left: 8px;
    background: rgba(0, 0, 0, 0.75);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

/* 2. Zone Intermédiaire : Métadonnées */
.course-meta {
    padding: 12px;
    flex-grow: 1;
}

/* A. Ligne des Statistiques */
.stats-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 0;
}

.stat {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

.stat i {
    color: #94a3b8;
    font-size: 10px;
}

/* B. Ligne d'Identification et Note */
.title-rating-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
}

.course-identity {
    flex: 1;
}

.course-main-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 3px 0;
    line-height: 1.2;
}

.course-subtitle {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
}

.rating {
    display: flex;
    align-items: center;
    gap: 2px;
    font-size: 11px;
    color: #f59e0b;
    font-weight: 700;
    background: #fffbeb;
    padding: 2px 6px;
    border-radius: 4px;
}

.rating i {
    font-size: 10px;
}

/* 3. Zone Inférieure : Actions */
.course-actions {
    padding: 0 12px 12px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.like-btn {
    background: transparent;
    color: #dc2626;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 14px;
    flex: 1;
    justify-content: center;
}

.like-btn:hover {
    background: #dc2626;
    color: white;
    transform: translateY(-1px);
}

.start-btn {
    background: #3498db;
    color: white;
    border: none;
    padding: 8px 0px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 12px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    flex: 2;
}

.start-btn:hover {
    background: #2E5FE0;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

/* SECTION FOOTER - ESPACES MINIMUM */
.section-footer {
    text-align: center;
    margin-top: 15px;
}

.load-more-btn {
    background: transparent;
    border: 1px solid #e2e8f0;
    color: #64748b;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
}

.load-more-btn:hover {
    border-color: #3498db;
    color: #3498db;
    background: #f8fafc;
    transform: translateY(-1px);
}

/* Message aucun cours */
.no-courses {
    text-align: center;
    padding: 30px 20px;
    color: #64748b;
}

.no-courses i {
    margin-bottom: 10px;
    color: #cbd5e1;
}

.no-courses h3 {
    font-size: 18px;
    margin-bottom: 8px;
    color: #475569;
}

.btn-reset {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 15px;
}

.btn-reset:hover {
    background: #2980b9;
}

/* Animation pour les sections */
.course-category-section {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .courses-grid-section {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .section-header-main {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .section-main-title {
        font-size: 1.5rem;
    }
    
    .section-slogan {
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .course-category-section {
        margin-bottom: 15px;
        padding: 10px 0;
    }
    
    .section-main-title {
        font-size: 1.3rem;
    }
    
    .section-slogan {
        font-size: 0.8rem;
    }
    
    .courses-grid-section {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .container {
        padding: 15px 20px;
    }
}

@media (max-width: 640px) {
    .search-filter-container {
        flex-direction: column;
        gap: 8px;
    }
    
    .search-bar, .filter-btn {
        width: 100%;
    }
    
    .course-actions {
        flex-direction: column;
        gap: 6px;
    }
    
    .like-btn, .start-btn {
        width: 100%;
        flex: none;
    }
    
    .main-header {
        padding: 15px 20px;
    }
    
    .container {
        padding: 10px 15px;
    }
}

@media (max-width: 480px) {
    .section-main-title {
        font-size: 1.2rem;
    }
    
    .section-slogan {
        font-size: 0.75rem;
    }
    
    .view-all-btn,
    .load-more-btn {
        width: 100%;
        justify-content: center;
        font-size: 11px;
    }
    
    .course-image-container {
        height: 140px;
    }
}
</style>