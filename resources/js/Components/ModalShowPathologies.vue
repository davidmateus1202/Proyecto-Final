<template>
    <div class="fixed inset-0 w-full h-full bg-black/50 z-20 flex justify-center items-center p-4">
        <div class="hidden md:flex flex-col w-full h-full items-start justify-start p-10 gap-4">
            <button @click="toggleShowModal"
                class="z-30 bg-white text-gray-400 w-10 h-10 aspect-square rounded-full shadow-2xl">
                x
            </button>

            <div
                class="flex flex-col bg-white w-full h-full rounded-2xl shadow-2xl items-center justify-center p-5 gap-y-4">
                <div class="flex w-full h-full justify-between items-center">
                    <button
                        @click="prevImage"
                        class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-400 w-10 h-10 aspect-square rounded-full shadow-2xl">
                        <IconArrowLeft stroke={2} />
                    </button>
                    <img :src="currentImage" alt=""
                        class="h-[600px] object-cover aspect-[5/6] rounded-2xl"></img>
                    <button
                        @click="nextImage"
                        class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-400 w-10 h-10 aspect-square rounded-full shadow-2xl">
                        <IconArrowRight stroke={2} />
                    </button>
                </div>
                <div class="w-full h-24 flex items-center">
                    <div class="flex flex-row gap-x-3 w-full overflow-x-auto py-2 px-2 hide-scrollbar">
                        <!-- Ejemplo de miniaturas, tu v-for está correcto -->
                        <img 
                            v-for="(item, index) in props.pathologies" 
                            :key="index" 
                            :src="item.url_image"
                            @click="setImage(index)"
                            class="w-20 h-20 object-cover hover:opacity-80 transition-opacity duration-300 ease-in-out cursor-pointer rounded-lg"
                            :class="index === currentIndex ? 'border-blue-500 border-4 scale-95' : 'border-gray-300 border-2 hover:opacity-80'"
                            > 
                    </div>
                </div>
            </div>
        </div>

        <div class="relative md:hidden flex flex-col bg-white w-full max-w-lg h-full max-h-[95vh] rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- BOTÓN DE CERRAR: Posicionado de forma absoluta dentro del modal para mejor control -->
            <button @click="toggleShowModal"
                class="absolute top-2 right-1 z-30 bg-white/70 text-gray-700 w-8 h-8 rounded-full shadow-md flex items-center justify-center hover:bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- 1. CONTENEDOR DE LA IMAGEN PRINCIPAL -->
            <!-- 'relative' para posicionar los botones dentro y 'flex-1' para que ocupe todo el espacio vertical disponible. -->
            <div class="relative w-full flex-1 flex justify-center items-center p-2">
                
                <!-- Botón Izquierda: Posicionado absolutamente -->
                <button @click="prevImage"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center bg-white/80 hover:bg-white text-gray-600 w-10 h-10 rounded-full shadow-lg">
                    <IconArrowLeft :stroke="2" />
                </button>

                <!-- Imagen principal: 'object-contain' para que se vea completa sin deformarse -->
                <img :src="currentImage" alt="Patología"
                    class="w-full h-full object-contain rounded-xl">

                <!-- Botón Derecha: Posicionado absolutamente -->
                <button @click="nextImage"
                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center bg-white/80 hover:bg-white text-gray-600 w-10 h-10 rounded-full shadow-lg">
                    <IconArrowRight :stroke="2" />
                </button>
            </div>

            <!-- 2. CONTENEDOR DE MINIATURAS -->
            <!-- Tiene una altura fija, permitiendo que el contenedor de la imagen principal se expanda. -->
            <div class="w-full h-24 flex items-center bg-gray-50 border-t border-gray-200">
                <div class="flex flex-row gap-x-3 w-full overflow-x-auto py-2 px-4 hide-scrollbar">
                    <img v-for="(item, index) in props.pathologies" 
                         :key="index" 
                         :src="item.url_image"
                         @click="setImage(index)"
                         class="w-20 h-20 object-cover transition-all duration-300 ease-in-out cursor-pointer rounded-lg flex-shrink-0"
                         :class="index === currentIndex ? 'border-blue-500 border-4' : 'border-gray-300 border-2 hover:opacity-80'">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { IconArrowLeft, IconArrowRight } from '@tabler/icons-vue';
import { computed, ref } from 'vue';

const emit = defineEmits(['closeModal'])
const currentIndex = ref(0);

const props = defineProps({
    pathologies: {
        type: Array,
        required: true,
        default: () => []
    }
})

const currentImage = computed(() => {
    if (props.pathologies.length > 0) {
        return props.pathologies[currentIndex.value].url_image;
    }
    return 'https://via.placeholder.com/800x600?text=No+Image';
})

const nextImage = () => {
    if (props.pathologies.length > 1) {
        currentIndex.value = (currentIndex.value + 1) % props.pathologies.length;
    }
};

const prevImage = () => {
    if (props.pathologies.length > 1) {
        currentIndex.value = (currentIndex.value - 1 + props.pathologies.length) % props.pathologies.length;
    }
};

const setImage = (index) => {
    currentIndex.value = index;
};

const toggleShowModal = () => {
    emit('closeModal');
}

</script>