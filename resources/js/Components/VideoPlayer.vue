<template>
    <div class="video-player-container">
        <!-- Loader -->
        <div v-if="loading" class="aspect-video bg-gray-900 rounded-2xl flex items-center justify-center">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-dj-blue mx-auto mb-4"></div>
                <p class="text-white text-lg">Chargement de la vidéo...</p>
            </div>
        </div>

        <!-- Player Vimeo -->
        <div v-else-if="videoType === 'vimeo'" class="aspect-video">
            <iframe 
                :src="`https://player.vimeo.com/video/${vimeoId}?badge=0&autopause=0&player_id=0&app_id=58479&autoplay=1&loop=0&muted=0`"
                class="w-full h-full rounded-2xl"
                frameborder="0" 
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen
                @load="onVideoLoad"
                ref="videoIframe"
            ></iframe>
        </div>

        <!-- Player YouTube -->
        <div v-else-if="videoType === 'youtube'" class="aspect-video">
            <iframe 
                :src="`https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&modestbranding=1`"
                class="w-full h-full rounded-2xl"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                @load="onVideoLoad"
                ref="videoIframe"
            ></iframe>
        </div>

        <!-- Player HTML5 -->
        <div v-else-if="videoType === 'html5'" class="aspect-video bg-black rounded-2xl overflow-hidden">
            <video 
                controls
                class="w-full h-full"
                @loadeddata="onVideoLoad"
                ref="videoElement"
            >
                <source :src="videoUrl" type="video/mp4">
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>
        </div>

        <!-- Player externe non supporté -->
        <div v-else class="aspect-video bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl flex items-center justify-center">
            <div class="text-center text-white p-8">
                <div class="text-6xl mb-4">🎬</div>
                <h3 class="text-2xl font-bold mb-2">Vidéo externe</h3>
                <p class="text-gray-300 mb-4">Cette vidéo est hébergée sur une plateforme externe</p>
                <a :href="videoUrl" target="_blank" 
                   class="inline-flex items-center space-x-2 bg-dj-blue hover:bg-blue-600 px-6 py-3 rounded-lg transition font-semibold">
                    <span>Ouvrir la vidéo</span>
                    <span>↗</span>
                </a>
            </div>
        </div>

        <!-- Contrôles personnalisés pour HTML5 -->
        <div v-if="videoType === 'html5' && !loading" class="mt-4 bg-gray-800 rounded-lg p-4">
            <div class="flex items-center justify-between space-x-4">
                <!-- Contrôles de base -->
                <div class="flex items-center space-x-4">
                    <button @click="togglePlay" class="w-10 h-10 bg-dj-blue rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <span class="text-white">{{ isPlaying ? '⏸️' : '▶️' }}</span>
                    </button>
                    
                    <button @click="toggleMute" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition">
                        <span class="text-white">{{ isMuted ? '🔇' : '🔊' }}</span>
                    </button>

                    <div class="text-white text-sm">
                        {{ formatTime(currentTime) }} / {{ formatTime(duration) }}
                    </div>
                </div>

                <!-- Barre de progression -->
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-700 rounded-full h-2 cursor-pointer" @click="seekVideo">
                        <div class="bg-dj-blue h-2 rounded-full transition-all duration-100" 
                             :style="{ width: progress + '%' }"></div>
                    </div>
                </div>

                <!-- Plein écran -->
                <button @click="toggleFullscreen" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition">
                    <span class="text-white">⛶</span>
                </button>
            </div>
        </div>

        <!-- Informations vidéo -->
        <div v-if="!loading" class="mt-4 bg-gray-800 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-sm text-gray-300">
                    <span>Type: {{ getVideoTypeName(videoType) }}</span>
                    <span>•</span>
                    <span>Durée: {{ lesson.duration }} minutes</span>
                    <span>•</span>
                    <span v-if="videoType !== 'external'" class="text-green-400">✓ Lecture intégrée</span>
                    <span v-else class="text-yellow-400">↗ Lien externe</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button @click="togglePlaybackSpeed" class="px-3 py-1 bg-gray-700 rounded text-sm text-gray-300 hover:bg-gray-600 transition">
                        {{ playbackSpeed }}x
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    lesson: Object,
    videoUrl: String
})

const loading = ref(true)
const videoElement = ref(null)
const videoIframe = ref(null)
const isPlaying = ref(false)
const isMuted = ref(false)
const currentTime = ref(0)
const duration = ref(0)
const playbackSpeed = ref(1.0)

// Computed properties
const videoType = computed(() => props.lesson.video_type)
const vimeoId = computed(() => props.lesson.vimeo_id)
const youtubeId = computed(() => props.lesson.youtube_id)

const progress = computed(() => {
    return duration.value > 0 ? (currentTime.value / duration.value) * 100 : 0
})

// Méthodes
const onVideoLoad = () => {
    loading.value = false
}

const togglePlay = () => {
    if (videoElement.value) {
        if (videoElement.value.paused) {
            videoElement.value.play()
            isPlaying.value = true
        } else {
            videoElement.value.pause()
            isPlaying.value = false
        }
    }
}

const toggleMute = () => {
    if (videoElement.value) {
        videoElement.value.muted = !videoElement.value.muted
        isMuted.value = videoElement.value.muted
    }
}

const seekVideo = (event) => {
    if (videoElement.value) {
        const rect = event.currentTarget.getBoundingClientRect()
        const percent = (event.clientX - rect.left) / rect.width
        videoElement.value.currentTime = percent * videoElement.value.duration
    }
}

const toggleFullscreen = () => {
    if (videoElement.value) {
        if (!document.fullscreenElement) {
            videoElement.value.requestFullscreen()
        } else {
            document.exitFullscreen()
        }
    }
}

const togglePlaybackSpeed = () => {
    if (videoElement.value) {
        const speeds = [0.5, 0.75, 1.0, 1.25, 1.5, 2.0]
        const currentIndex = speeds.indexOf(playbackSpeed.value)
        const nextIndex = (currentIndex + 1) % speeds.length
        playbackSpeed.value = speeds[nextIndex]
        videoElement.value.playbackRate = playbackSpeed.value
    }
}

const formatTime = (seconds) => {
    const mins = Math.floor(seconds / 60)
    const secs = Math.floor(seconds % 60)
    return `${mins}:${secs.toString().padStart(2, '0')}`
}

const getVideoTypeName = (type) => {
    const names = {
        vimeo: 'Vimeo',
        youtube: 'YouTube',
        html5: 'Vidéo MP4',
        external: 'Lien externe'
    }
    return names[type] || 'Inconnu'
}

// Écouteurs d'événements pour HTML5
const updateTime = () => {
    if (videoElement.value) {
        currentTime.value = videoElement.value.currentTime
        duration.value = videoElement.value.duration
    }
}

onMounted(() => {
    if (videoElement.value) {
        videoElement.value.addEventListener('timeupdate', updateTime)
        videoElement.value.addEventListener('loadedmetadata', updateTime)
        videoElement.value.addEventListener('play', () => isPlaying.value = true)
        videoElement.value.addEventListener('pause', () => isPlaying.value = false)
    }
})

onUnmounted(() => {
    if (videoElement.value) {
        videoElement.value.removeEventListener('timeupdate', updateTime)
        videoElement.value.removeEventListener('loadedmetadata', updateTime)
        videoElement.value.removeEventListener('play', () => isPlaying.value = true)
        videoElement.value.removeEventListener('pause', () => isPlaying.value = false)
    }
})
</script>

<style scoped>
.video-player-container {
    position: relative;
}

/* Styles pour le mode plein écran */
:fullscreen .video-player-container {
    width: 100vw;
    height: 100vh;
    background: black;
}

:fullscreen .video-player-container video {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>