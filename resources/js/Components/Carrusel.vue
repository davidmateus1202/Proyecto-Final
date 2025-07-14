<template>
    <div class="relative h-screen w-screen overflow-hidden bg-blue-600">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <transition
                :name="transitionName">
                <img v-if="currentImage.src" 
                    :key="currentImage.src" 
                    :src="currentImage.src"
                    class="object-cover w-full h-full" 
                    alt="Background Image" />
            </transition>
        </div>

        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>

        <div class="relative z-20 flex flex-col items-center justify-center h-full">
            <h1 class="text-2xl md:text-4xl lg:text-5xl xl:text-6xl font-semibold text-center text-white mb-5 md:mb-0">Evaluación Vial Asistida por <br> Inteligencia Artificial</h1>
            <p class="hidden md:block mt-4 text-sm md:text-lg text-white font-semibold mb-5">Sistema basado en inteligencia artificial para la detección, clasificación y diagnóstico de daños en tramos viales.</p>
            <Button :action="() => navigateTo('Reserve')" :text="'R e s e r v a r'" />
        </div>

          <template v-if="images.length > 1">
            <!-- Botón Anterior -->
            <button
                @click="prevImage"
                class="absolute top-1/2 -translate-y-1/2 left-3 sm:left-5 md:left-8 z-30 p-2 sm:p-3 bg-white/20 hover:bg-white/40 text-white rounded-full focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300 ease-in-out"
                aria-label="Imagen anterior"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- Botón Siguiente -->
            <button
                @click="nextImage"
                class="absolute top-1/2 -translate-y-1/2 right-3 sm:right-5 md:right-8 z-30 p-2 sm:p-3 bg-white/20 hover:bg-white/40 text-white rounded-full focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300 ease-in-out"
                aria-label="Siguiente imagen"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </template>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import Button from './Button.vue'; // Asegúrate que la ruta es correcta
import fondo1 from '../assets/fondo1.jpg';
import fondo2 from '../assets/fondo2.jpg';
import fondo3 from '../assets/fondo3.jpg';
import { useRouter } from 'vue-router'; // Importa useRouter si necesitas navegación
import '../CSS/Carrusel.css';

const images = ref([
    { src: fondo1, alt: 'Image 1' },
    { src: fondo2, alt: 'Image 2' },
    { src: fondo3, alt: 'Image 3' },
]);

const router = useRouter(); // Inicializa el router si necesitas navegación
const currentIndex = ref(0);
const intervalId = ref(null);
const transitionDuration = 5000; // Duración del intervalo para cambio automático
const animationDuration = 0.7; // Duración de la animación CSS en segundos

const transitionName = ref('slide-right'); // Nombre de la transición (slide-left o slide-right)

const currentImage = computed(() => images.value[currentIndex.value]);

const resetInterval = () => {
    if (intervalId.value) {
        clearInterval(intervalId.value);
    }
    if (images.value.length > 1) {
        intervalId.value = setInterval(() => {
            // Para el autoplay, siempre deslizamos como si fuera "siguiente"
            transitionName.value = 'slide-right';
            currentIndex.value = (currentIndex.value + 1) % images.value.length;
        }, transitionDuration);
    }
};

// Función genérica para ir a una imagen, estableciendo la dirección de la transición
const goToImage = (index, direction) => {
    if (currentIndex.value === index && images.value.length > 1) return; // No hacer nada si es la misma imagen, a menos que sea la única

    transitionName.value = direction;
    currentIndex.value = index;
    resetInterval(); // Reiniciar el intervalo de autoplay después de un cambio manual
};

const nextImage = () => {
    const newIndex = (currentIndex.value + 1) % images.value.length;
    goToImage(newIndex, 'slide-right');
};

const prevImage = () => {
    const newIndex = (currentIndex.value - 1 + images.value.length) % images.value.length;
    goToImage(newIndex, 'slide-left');
};

onMounted(() => {
    resetInterval(); // Iniciar el autoplay al montar el componente
});

onUnmounted(() => {
    if (intervalId.value) {
        clearInterval(intervalId.value);
    }
});

const navigateTo = (path) => {
    router.push({ path });
}
</script>

<style>

/* Estilos base para ambas transiciones de deslizamiento */
.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
    transition: all v-bind(animationDuration + 's') ease-in-out; /* Usando v-bind para la duración */
    position: absolute; /* Muy importante para que las imágenes se superpongan y deslicen */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

</style>