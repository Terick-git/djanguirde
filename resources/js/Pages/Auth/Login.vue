<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <!-- Carte avec effet profondeur -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20">
                <!-- En-tête premium -->
                <div class="p-8 pb-6 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 relative">
                        <div class="absolute inset-0 bg-blue-500/10 rounded-2xl transform rotate-6"></div>
                        <img 
                            src="/images/logo.png" 
                            alt="Djanguirde"
                            class="w-full h-full object-contain relative z-10 drop-shadow-lg"
                            @error="useFallbackLogo = true"
                        />
                        <div v-if="useFallbackLogo" class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center relative z-10 shadow-lg">
                            <span class="text-white font-bold text-2xl">D</span>
                        </div>
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 mb-1 bg-gradient-to-r from-gray-900 to-blue-800 bg-clip-text text-transparent">
                        Djanguirde
                    </h1>
                    <p class="text-gray-500 text-sm font-medium">Votre succès commence ici</p>
                </div>

                <!-- Formulaire élégant -->
                <div class="px-8 pb-8">
                    <form class="space-y-5" @submit.prevent="submit">
                        <!-- Email avec icône -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 shadow-sm"
                                    placeholder="votregmail.com"
                                    @input="checkUserType"
                                />
                            </div>
                        </div>

                        <!-- Mot de passe avec icône -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    v-model="form.password"
                                    type="password"
                                    required
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 shadow-sm"
                                    placeholder="Votre mot de passe"
                                />
                            </div>
                        </div>

                        <!-- Code d'accès élégant -->
                        <div v-if="showAccessCode" class="bg-blue-50/50 border border-blue-200 rounded-xl p-4 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <input
                                    v-model="form.access_code"
                                    type="password"
                                    required
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-blue-400"
                                    placeholder="Code 3xDev"
                                />
                            </div>
                            <p class="text-xs text-blue-600 mt-2 font-medium">
                                Accès réservé admin/formateur
                            </p>
                        </div>

                        <!-- Bouton premium -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3.5 px-4 rounded-xl font-bold hover:from-blue-600 hover:to-blue-700 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:transform-none shadow-lg shadow-blue-500/25"
                        >
                            <span v-if="form.processing" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Connexion...
                            </span>
                            <span v-else class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Se connecter
                            </span>
                        </button>
                    </form>

                    <!-- Lien élégant -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-500 text-sm">
                            Nouveau sur Djanguirde ?
                            <Link href="/register" class="text-blue-600 hover:text-blue-700 font-bold transition-colors">
                                Créer un compte
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
    email: '',
    password: '',
    access_code: '',
    remember: true,
})

const useFallbackLogo = ref(false)

const showAccessCode = computed(() => {
    const adminEmails = ['admin@', 'djanguirde.com']
    return adminEmails.some(pattern => form.email.includes(pattern))
})

onMounted(() => {
    const savedEmail = localStorage.getItem('djanguirde_email')
    if (savedEmail) {
        form.email = savedEmail
    }
})

const checkUserType = () => {
    if (form.email) {
        localStorage.setItem('djanguirde_email', form.email)
    }
}

const submit = () => {
    if (form.email) {
        localStorage.setItem('djanguirde_email', form.email)
    }

    form.post('/login')
}
</script>