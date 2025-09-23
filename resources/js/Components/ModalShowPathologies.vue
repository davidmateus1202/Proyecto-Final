<template>
    <!-- Contenedor de fondo y centrado -->
    <div class="fixed inset-0 w-full h-full bg-black/50 z-20 flex justify-center items-center p-4 overflow-hidden">

        <!-- Contenedor principal del modal -->
        <div class="relative flex flex-col lg:flex-row bg-white w-full max-w-6xl h-full max-h-[95vh] rounded-2xl shadow-2xl overflow-hidden overflow-y-auto lg:overflow-y-hidden">
            
            <!-- BOTÓN DE CERRAR -->
            <button @click="toggleShowModal"
                class="absolute top-3 right-3 z-30 bg-white/80 text-gray-700 w-9 h-9 rounded-full shadow-md flex items-center justify-center hover:bg-white transition-colors">
                <svg xmlns="http://www.w.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- SECCIÓN 1: VISOR DE IMÁGENES -->
            <div class="flex flex-col w-full lg:w-2/3 h-auto lg:h-full flex-shrink-0">
                <!-- Contenedor de la imagen principal -->
                <div class="relative w-full h-96 md:h-[450px] lg:flex-1 flex justify-center items-center p-2 min-h-0">
                    <button @click="prevImage" class="absolute left-3 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center bg-white/80 hover:bg-white text-gray-600 w-10 h-10 rounded-full shadow-lg">
                        <IconArrowLeft :stroke="2" />
                    </button>
                    <img v-if="currentImage" :src="currentImage" alt="Patología" class="w-full h-full object-contain rounded-xl">
                    <div v-else class="text-gray-500">No hay imagen disponible</div>
                    <button @click="nextImage" class="absolute right-3 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center bg-white/80 hover:bg-white text-gray-600 w-10 h-10 rounded-full shadow-lg">
                        <IconArrowRight :stroke="2" />
                    </button>
                </div>
                <!-- Contenedor de miniaturas -->
                <div class="w-full h-24 flex items-center bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-row gap-x-3 w-full overflow-x-auto py-2 px-4 hide-scrollbar">
                        <img v-for="(item, index) in props.pathologies" 
                             :key="item.id" 
                             :src="item.url_image"
                             @click="setImage(index)"
                             class="w-20 h-20 object-cover transition-all duration-300 ease-in-out cursor-pointer rounded-lg flex-shrink-0"
                             :class="index === currentIndex ? 'border-blue-500 border-4' : 'border-gray-300 border-2 hover:opacity-80'">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: TARJETA DE DATOS (CORREGIDA) -->
            <div class="w-full lg:w-1/3 h-auto lg:h-full bg-slate-50 border-t-2 lg:border-t-0 lg:border-l-2 border-gray-200 overflow-y-auto hide-scrollbar">
                <div v-if="currentPathology" class="p-6 space-y-6">
                    <!-- Encabezado -->
                    <div>
                        <span class="text-sm font-medium text-blue-600 bg-blue-100 rounded-full px-3 py-1">{{ currentPathology.type_damage }}</span>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">{{ formatName(currentPathology.name) }}</h1>
                        <p class="text-sm text-gray-500 mt-1">ID de Losa: {{ currentPathology.slab_id }}</p>
                    </div>

                    <!-- Dimensiones del Daño -->
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Dimensiones del Daño</h2>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <!-- ANTES: <InfoItem ... /> -->
                            <!-- AHORA: -->
                            <div class="flex items-center gap-x-3">
                                <IconRuler class="w-6 h-6 text-gray-400 flex-shrink-0" />
                                <div>
                                    <p class="text-sm text-gray-500">Largo</p>
                                    <p class="font-bold text-gray-800">{{ currentPathology.long_damage }} {{ currentPathology.type_long_damage }}</p>
                                </div>
                            </div>
                            <!-- ANTES: <InfoItem ... /> -->
                            <!-- AHORA: -->
                            <div class="flex items-center gap-x-3">
                                <IconDimensions class="w-6 h-6 text-gray-400 flex-shrink-0" />
                                <div>
                                    <p class="text-sm text-gray-500">Ancho</p>
                                    <p class="font-bold text-gray-800">{{ currentPathology.width_damage }} {{ currentPathology.type_width_damage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dimensiones de Reparación -->
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Dimensiones de Reparación</h2>
                         <div class="grid grid-cols-2 gap-4 pt-2">
                            <!-- ANTES: <InfoItem ... /> -->
                            <!-- AHORA: -->
                             <div class="flex items-center gap-x-3">
                                <IconRuler class="w-6 h-6 text-gray-400 flex-shrink-0" />
                                <div>
                                    <p class="text-sm text-gray-500">Largo</p>
                                    <p class="font-bold text-gray-800">{{ currentPathology.repair_long }} {{ currentPathology.type_repair_long }}</p>
                                </div>
                            </div>
                            <!-- ANTES: <InfoItem ... /> -->
                            <!-- AHORA: -->
                            <div class="flex items-center gap-x-3">
                                <IconDimensions class="w-6 h-6 text-gray-400 flex-shrink-0" />
                                <div>
                                    <p class="text-sm text-gray-500">Ancho</p>
                                    <p class="font-bold text-gray-800">{{ currentPathology.repair_width }} {{ currentPathology.type_repair_width }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metadatos -->
                     <div class="pt-4 border-t">
                        <div class="flex items-center gap-x-3 text-sm text-gray-500">
                           <IconCalendar class="w-5 h-5" />
                           <span>Registrado el: {{ formatDate(currentPathology.created_at) }}</span>
                        </div>
                     </div>
                </div>
                <div v-else class="flex items-center justify-center h-full text-gray-500 p-6">
                    <p>No hay datos para mostrar.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// Asegúrate de que no haya ninguna línea 'import InfoItem ...' aquí.
import { IconArrowLeft, IconArrowRight, IconRuler, IconDimensions, IconCalendar } from '@tabler/icons-vue';
import { computed, ref } from 'vue';

const emit = defineEmits(['closeModal']);
const currentIndex = ref(0);

const props = defineProps({
    pathologies: {
        type: Array,
        required: true,
        default: () => []
    }
});

const currentPathology = computed(() => {
    return props.pathologies.length > 0 ? props.pathologies[currentIndex.value] : null;
});

const currentImage = computed(() => {
    return currentPathology.value ? currentPathology.value.url_image : null;
});

const formatName = (name) => {
    if (!name) return '';
    return name.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
};

const nextImage = () => { if (props.pathologies.length > 1) { currentIndex.value = (currentIndex.value + 1) % props.pathologies.length; } };
const prevImage = () => { if (props.pathologies.length > 1) { currentIndex.value = (currentIndex.value - 1 + props.pathologies.length) % props.pathologies.length; } };
const setImage = (index) => { currentIndex.value = index; };
const toggleShowModal = () => { emit('closeModal'); };

</script>

<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>