<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Bienvenue sur 
                        <span class="brand-gradient">DJANGUIRDE</span>
                    </h1>
                    <p class="hero-subtitle">
                        La plateforme e-learning qui révolutionne l'apprentissage au secondaire. 
                        Cours interactifs, exercices corrigés et suivi personnalisé pour exceller 
                        dans toutes les matières.
                    </p>
                    <div class="hero-actions">
                        <Link href="/courses" class="btn-primary">
                            Découvrir nos cours
                            <i class="fas fa-arrow-right"></i>
                        </Link>
                        <Link href="/register" class="btn-secondary">
                            Commencer gratuitement
                        </Link>
                    </div>
                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Cours disponibles</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Élèves actifs</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">De réussite</div>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="floating-cards">
                        <div class="card math">
                            <i class="fas fa-calculator"></i>
                            <span>Mathématiques</span>
                        </div>
                        <div class="card physics">
                            <i class="fas fa-atom"></i>
                            <span>Physique</span>
                        </div>
                        <div class="card english">
                            <i class="fas fa-language"></i>
                            <span>Anglais</span>
                        </div>
                        <div class="card code">
                            <i class="fas fa-code"></i>
                            <span>Programmation</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Pourquoi choisir DJANGUIRDE ?</h2>
                    <p class="section-subtitle">
                        Une expérience d'apprentissage unique adaptée aux besoins des collégiens et lycéens
                    </p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>Cours Expertisés</h3>
                        <p>Des contenus pédagogiques créés par des enseignants certifiés et experts dans leur domaine.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <h3>Vidéos Interactives</h3>
                        <p>Des leçons vidéo de qualité avec exercices intégrés pour un apprentissage engageant.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Suivi Personnalisé</h3>
                        <p>Tableau de bord détaillé pour suivre votre progression et identifier les points à améliorer.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Accessible Partout</h3>
                        <p>Apprenez à votre rythme, sur tous vos appareils, même hors connexion.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Courses Preview -->
        <section class="courses-preview-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Cours Populaires</h2>
                    <p class="section-subtitle">
                        Découvrez nos cours les plus appréciés par la communauté
                    </p>
                </div>
                <div class="courses-preview-grid">
                    <div class="preview-course-card" v-for="course in popularCourses" :key="course.id">
                        <div class="course-image">
                            <img :src="course.image" :alt="course.title" />
                            <div class="course-badge">{{ course.category }}</div>
                        </div>
                        <div class="course-content">
                            <h3>{{ course.title }}</h3>
                            <p>{{ course.description }}</p>
                            <div class="course-meta">
                                <div class="meta-item">
                                    <i class="fas fa-play-circle"></i>
                                    <span>{{ course.lessons }} leçons</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-star"></i>
                                    <span>{{ course.rating }}</span>
                                </div>
                            </div>
                            <div class="course-price" :class="{ free: course.isFree }">
                                {{ course.isFree ? 'Gratuit' : course.price }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-actions">
                    <Link href="/courses" class="btn-outline">
                        Voir tous les cours
                        <i class="fas fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="how-it-works-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Comment ça marche ?</h2>
                    <p class="section-subtitle">
                        Apprenez efficacement en 4 étapes simples
                    </p>
                </div>
                <div class="steps-grid">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Inscription Rapide</h3>
                            <p>Créez votre compte en 2 minutes et accédez à tous nos contenus</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Choix des Cours</h3>
                            <p>Parcourez notre catalogue et sélectionnez vos matières préférées</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Apprentissage Actif</h3>
                            <p>Suivez les vidéos, faites les exercices et testez vos connaissances</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>Progression Suivie</h3>
                            <p>Visualisez vos progrès et obtenez des certifications</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Prêt à transformer votre apprentissage ?</h2>
                    <p>Rejoignez des milliers d'élèves qui excellent grâce à DJANGUIRDE</p>
                    <div class="cta-actions">
                        <Link href="/register" class="btn-primary large">
                            S'inscrire Maintenant
                        </Link>
                        <Link href="/about" class="btn-secondary large">
                            En savoir plus
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Données simulées pour les cours populaires
const popularCourses = [
    {
        id: 1,
        title: 'Mathématiques Avancées',
        description: 'Maîtrisez les concepts complexes des mathématiques du lycée',
        category: 'Maths',
        lessons: 24,
        rating: '4.8',
        isFree: false,
        price: '29,99€',
        image: '/images/img1.jpg'
    },
    {
        id: 2,
        title: 'Physique Quantique',
        description: 'Introduction aux concepts fondamentaux de la physique moderne',
        category: 'Physique',
        lessons: 18,
        rating: '4.7',
        isFree: true,
        price: 'Gratuit',
        image: '/images/img2.jpg'
    },
    {
        id: 3,
        title: 'Programmation Python',
        description: 'Apprenez à coder en Python avec des projets pratiques',
        category: 'Informatique',
        lessons: 32,
        rating: '4.9',
        isFree: false,
        price: '39,99€',
        image: '/images/img3.jpg'
    }
]
</script>

<style scoped>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #7CBCF8 0%, #2E5FE0 100%);
    color: white;
    padding: 80px 0;
    min-height: 80vh;
    display: flex;
    align-items: center;
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}

.brand-gradient {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: 32px;
    opacity: 0.9;
}

.hero-actions {
    display: flex;
    gap: 16px;
    margin-bottom: 48px;
    flex-wrap: wrap;
}

.btn-primary {
    background: white;
    color: #2E5FE0;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: 2px solid white;
}

.btn-primary:hover {
    background: transparent;
    color: white;
    transform: translateY(-2px);
}

.btn-secondary {
    background: transparent;
    color: white;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: 2px solid white;
}

.btn-secondary:hover {
    background: white;
    color: #2E5FE0;
    transform: translateY(-2px);
}

.hero-stats {
    display: flex;
    gap: 40px;
}

.stat {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Floating Cards Animation */
.hero-visual {
    position: relative;
    height: 400px;
}

.floating-cards {
    position: relative;
    width: 100%;
    height: 100%;
}

.card {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: white;
    font-weight: 600;
    animation: float 6s ease-in-out infinite;
}

.card i {
    font-size: 2rem;
    margin-bottom: 8px;
}

.card.math {
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.card.physics {
    top: 60%;
    left: 70%;
    animation-delay: 1.5s;
}

.card.english {
    top: 30%;
    left: 60%;
    animation-delay: 3s;
}

.card.code {
    top: 70%;
    left: 20%;
    animation-delay: 4.5s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

/* Features Section */
.features-section {
    padding: 80px 0;
    background: #f8fafc;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a202c;
    margin-bottom: 16px;
}

.section-subtitle {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 32px;
}

.feature-card {
    background: white;
    padding: 40px 32px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #7CBCF8, #2E5FE0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: white;
    font-size: 2rem;
}

.feature-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
}

.feature-card p {
    color: #64748b;
    line-height: 1.6;
}

/* Courses Preview Section */
.courses-preview-section {
    padding: 80px 0;
}

.courses-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 32px;
    margin-bottom: 48px;
}

.preview-course-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.preview-course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.course-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background: #2E5FE0;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.course-content {
    padding: 24px;
}

.course-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 8px;
}

.course-content p {
    color: #64748b;
    line-height: 1.5;
    margin-bottom: 16px;
}

.course-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.9rem;
    color: #64748b;
}

.course-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #059669;
}

.course-price.free {
    color: #059669;
}

.section-actions {
    text-align: center;
}

.btn-outline {
    background: transparent;
    color: #2E5FE0;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: 2px solid #2E5FE0;
}

.btn-outline:hover {
    background: #2E5FE0;
    color: white;
    transform: translateY(-2px);
}

/* How It Works Section */
.how-it-works-section {
    padding: 80px 0;
    background: #f8fafc;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.step-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #7CBCF8, #2E5FE0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
    flex-shrink: 0;
}

.step-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 8px;
}

.step-content p {
    color: #64748b;
    line-height: 1.6;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #2E5FE0 0%, #7CBCF8 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.cta-content h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 16px;
}

.cta-content p {
    font-size: 1.25rem;
    margin-bottom: 32px;
    opacity: 0.9;
}

.cta-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary.large {
    padding: 16px 40px;
    font-size: 1.125rem;
}

.btn-secondary.large {
    padding: 16px 40px;
    font-size: 1.125rem;
}

/* Responsive Design */
@media (max-width: 968px) {
    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 40px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .features-grid,
    .courses-preview-grid,
    .steps-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 640px) {
    .hero-section {
        padding: 60px 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .container {
        padding: 0 20px;
    }
}

@media (max-width: 480px) {
    .hero-content {
        padding: 0 20px;
    }
    
    .floating-cards {
        display: none;
    }
    
    .feature-card {
        padding: 32px 24px;
    }
    
    .step {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
}
</style>