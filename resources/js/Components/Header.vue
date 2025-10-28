<template>
    <header class="bg-[#7CBCF8] shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo et Nom à gauche -->
                <div class="flex items-center space-x-3">
                    <Link href="/" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                        <div class="w-12 h-12 relative">
                            <img 
                                src="/images/logo.png" 
                                alt="Djanguirde"
                                class="w-full h-full object-contain"
                                @error="useFallbackLogo = true"
                            />
                            <div v-if="useFallbackLogo" class="w-full h-full bg-black rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold text-lg">D</span>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-blue-600 font-bold text-2xl">
                                DJANGUIRDE
                            </h1>
                        </div>
                    </Link>
                </div>

                <!-- Navigation centrale - Desktop -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <Link 
                        href="/" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg"
                        :class="{ 'text-black border-b-2 border-black': $page.url === '/' }"
                    >
                        Home
                    </Link>
                    <Link 
                        href="/courses" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg"
                        :class="{ 'text-black border-b-2 border-black': $page.url.startsWith('/courses') }"
                    >
                        Course
                    </Link>
                    <Link 
                        href="/dashboard" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg"
                        :class="{ 'text-black border-b-2 border-black': $page.url === '/dashboard' }"
                    >
                        Dashboard
                    </Link>
                    <Link 
                        href="/about" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg"
                        :class="{ 'text-black border-b-2 border-black': $page.url.startsWith('/about') }"
                    >
                        About
                    </Link>
                    <Link 
                        href="/blog" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg"
                        :class="{ 'text-black border-b-2 border-black': $page.url.startsWith('/blog') }"
                    >
                        Blog
                    </Link>
                </nav>

                <!-- Bouton menu mobile -->
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-lg hover:bg-blue-600 transition-colors"
                >
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Boutons à droite - Desktop -->
                <div class="hidden lg:flex items-center space-x-4">
                    <template v-if="$page.props.auth.user">
                        <!-- Menu utilisateur connecté -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-600 transition-colors">
                                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">
                                    <span class="text-sm">
                                        {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                    </span>
                                </div>
                                <span class="text-black font-medium">
                                    {{ $page.props.auth.user.name }}
                                </span>
                            </button>
                            
                            <!-- Menu déroulant -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <Link 
                                    href="/dashboard" 
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                >
                                    📊 Dashboard
                                </Link>
                                <Link 
                                    href="/profile" 
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                >
                                    👤 Mon Profil
                                </Link>
                                <div class="border-t border-gray-200 my-1"></div>
                                <Link 
                                    href="/logout" 
                                    method="post"
                                    class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors"
                                >
                                    🚪 Déconnexion
                                </Link>
                            </div>
                        </div>
                    </template>
                    
                    <template v-else>
                        <!-- Boutons Login/Register -->
                        <div class="flex items-center space-x-3">
                            <Link 
                                href="/login" 
                                class="bg-black text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-800 transition-all duration-200 text-lg shadow-sm"
                            >
                                Login
                            </Link>
                            <Link 
                                href="/register" 
                                class="bg-white text-black border-2 border-black px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 text-lg"
                            >
                                Register
                            </Link>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div v-if="mobileMenuOpen" class="lg:hidden border-t border-blue-600 py-4 bg-[#7CBCF8]">
                <nav class="flex flex-col space-y-4">
                    <Link 
                        href="/" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg py-2"
                        @click="mobileMenuOpen = false"
                    >
                        Home
                    </Link>
                    <Link 
                        href="/courses" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg py-2"
                        @click="mobileMenuOpen = false"
                    >
                        Course
                    </Link>
                    <Link 
                        href="/dashboard" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg py-2"
                        @click="mobileMenuOpen = false"
                    >
                        Dashboard
                    </Link>
                    <Link 
                        href="/about" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg py-2"
                        @click="mobileMenuOpen = false"
                    >
                        About
                    </Link>
                    <Link 
                        href="/blog" 
                        class="text-black hover:text-gray-800 font-medium transition-colors text-lg py-2"
                        @click="mobileMenuOpen = false"
                    >
                        Blog
                    </Link>
                    
                    <!-- Boutons mobile pour non connecté -->
                    <template v-if="!$page.props.auth.user">
                        <div class="flex flex-col space-y-3 pt-4">
                            <Link 
                                href="/login" 
                                class="bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 text-center transition-colors"
                                @click="mobileMenuOpen = false"
                            >
                                Login
                            </Link>
                            <Link 
                                href="/register" 
                                class="bg-white text-black border-2 border-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 text-center transition-colors"
                                @click="mobileMenuOpen = false"
                            >
                                Register
                            </Link>
                        </div>
                    </template>
                </nav>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const useFallbackLogo = ref(false)
const mobileMenuOpen = ref(false)
</script>