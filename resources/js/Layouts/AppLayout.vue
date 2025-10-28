<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <!-- Header -->
        <Header />
        
        <!-- Contenu Principal -->
        <main class="flex-1">
            <slot />
        </main>
        
        <!-- Footer (optionnel) -->
        <Footer />
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue' // Si vous en créez un
</script>