<template>
    <footer class="footer">
        <div class="footer-main">
            <!-- Colonne Gauche - FOLLOW US -->
            <div class="social-section">
                <div class="social-title">FOLLOW US</div>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg class="social-icon" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="X">
                        <svg class="social-icon" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <svg class="social-icon" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Colonne Droite - Liens -->
            <div class="links-section">
                <div class="footer-links-grid">
                    <div class="links-column">
                        <Link href="/" class="footer-link">Home</Link>
                        <Link href="/courses" class="footer-link">Course</Link>
                        <Link href="/about" class="footer-link">About</Link>
                        <Link href="/blog" class="footer-link">Blog</Link>
                        <Link href="/login" class="footer-link">Login</Link>
                    </div>
                    <div class="links-column">
                        <Link href="/contact" class="footer-link">Contact</Link>
                        <Link href="/terms" class="footer-link">Terms of Use</Link>
                        <Link href="/faq" class="footer-link">FAQ</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">&copy; 2024 DJANGUIRDE. All rights reserved.</p>
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
.footer {
    background-color: #7CBCF8;
    padding: 2rem 1rem 1rem;
    margin-top: auto;
}

.footer-main {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(46, 95, 224, 0.3);
}

/* Colonne Gauche - FOLLOW US */
.social-section {
    width: 200px;
    margin-right: 50px; /* ESPACE EXACT ENTRE LES COLONNES */
}

.social-title {
    color: #000000;
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.social-links {
    display: flex;
    gap: 0.8rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    color: #000000;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.social-icon {
    width: 20px;
    height: 20px;
    fill: currentColor;
}

.social-link:hover {
    background: #000000;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Colonne Droite - Liens */
.links-section {
    flex: 1;
    max-width: 400px;
}

.footer-links-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px; /* ESPACE ENTRE LES DEUX COLONNES DE LIENS */
}

.links-column {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.footer-link {
    color: #000000;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    white-space: nowrap;
    padding: 0.2rem 0;
    position: relative;
}

.footer-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: #000000;
    transition: width 0.3s ease;
}

.footer-link:hover {
    color: #2E5FE0;
    transform: translateX(3px);
}

.footer-link:hover::after {
    width: 100%;
}

.footer-bottom {
    max-width: 800px;
    margin: 1.5rem auto 0;
    text-align: center;
    color: #000000;
    font-weight: 700;
    padding-top: 1.5rem;
}

.copyright {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .footer {
        padding: 1.5rem 1rem 1rem;
    }

    .footer-main {
        flex-direction: column;
        gap: 2rem;
        text-align: center;
    }

    .social-section {
        width: 100%;
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .links-section {
        max-width: 100%;
        width: 100%;
    }

    .footer-links-grid {
        gap: 30px;
        justify-content: center;
    }

    .social-links {
        justify-content: center;
    }
    
    .social-title {
        font-size: 1.2rem;
    }
    
    .footer-link {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .footer-links-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        text-align: center;
    }

    .footer {
        padding: 1.5rem 0.5rem 1rem;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
    }
    
    .social-icon {
        width: 18px;
        height: 18px;
    }
    
    .footer-link {
        font-size: 0.95rem;
    }
    
    .copyright {
        font-size: 0.9rem;
    }
}
</style>