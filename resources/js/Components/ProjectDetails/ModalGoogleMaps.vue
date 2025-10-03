<template>
    <div class="fixed inset-0 bg-black bg-opacity-30 z-40 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-lg flex flex-col w-full max-w-sm sm:max-w-md md:max-w-3xl lg:max-w-5xl h-full max-h-[90vh] p-4 gap-4">

            <!-- Botón de Cerrar -->
            <button
                @click="closeModal"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 z-50 p-2 rounded-full hover:bg-gray-100 transition-colors"
                aria-label="Cerrar modal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Contenedor principal de Mapa y Detalles -->
            <!-- Añadido overflow-hidden para asegurar que el contenido interno no se desborde del scroll general si todo el modal fuera scrollable -->
            <div class="flex flex-col md:flex-row flex-grow gap-4 overflow-hidden">
                <!-- Sección del Mapa -->
                <!--
                    ¡CAMBIO CLAVE AQUÍ!
                    Se elimina 'h-[300px]' para que 'flex-grow' pueda distribuir la altura dinámicamente en móvil.
                    'min-h-[250px]' asegura que el mapa no sea demasiado pequeño.
                    'md:h-full' mantiene el mapa ocupando la altura completa en desktop.
                -->
                <div ref="mapDiv" class="flex-grow md:w-2/3 md:h-full rounded-2xl overflow-hidden min-h-[250px]"></div>

                <!-- Sección de Detalles de la Placa -->
                <!--
                    ¡CAMBIO CLAVE AQUÍ!
                    Añadido 'flex-grow' para que esta sección también comparta el espacio vertical
                    disponible en móviles (flex-col).
                    'overflow-y-auto' sigue siendo importante para desplazar el contenido de la tarjeta
                    si este excede la altura asignada.
                -->
                <div class="md:w-1/3 p-6 bg-white border border-gray-200 rounded-2xl flex flex-col overflow-y-auto shadow-sm flex-grow hide-scrollbar">
                    <h2 class="text-2xl font-semibold text-gray-900 pb-3 mb-4 border-b border-gray-200">Detalles de la Placa</h2>
                    <div v-if="slabData" class="space-y-4 text-gray-700 flex-grow">
                        <!-- ID de Placa -->
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <div>
                                <span class="font-medium text-gray-600 text-sm">ID de Placa:</span>
                                <p class="text-gray-900 font-semibold">{{ slabData.id }}</p>
                            </div>
                        </div>

                        <!-- ID de Abscisa -->
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 8v4m-4-8H4m8 0h4m-4 8H4m8 0h4" />
                            </svg>
                            <div>
                                <span class="font-medium text-gray-600 text-sm">ID de Abscisa:</span>
                                <p class="text-gray-900">{{ slabData.abscisa_id }}</p>
                            </div>
                        </div>

                        <!-- Latitud -->
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <span class="font-medium text-gray-600 text-sm">Latitud:</span>
                                <p class="text-gray-900">{{ slabData.latitude }}</p>
                            </div>
                        </div>

                        <!-- Longitud -->
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <span class="font-medium text-gray-600 text-sm">Longitud:</span>
                                <p class="text-gray-900">{{ slabData.longitude }}</p>
                            </div>
                        </div>

                        <!-- Dimensiones -->
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5 5 0 0010.283 2.537M10.5 5.25v2.25M10.5 12h.008c.706 0 1.282-.576 1.282-1.282V9.32a.66.66 0 011.23-.374l.11-.237c.307-.653 1.054-1.025 1.76-.799l.394.137c.706.246 1.053 1.033.746 1.786l-.11.237a.66.66 0 01-.234.33c-.112.083-.287.164-.49.196L14 12c-1.38 0-2.5 1.12-2.5 2.5s1.12 2.5 2.5 2.5H16a.75.75 0 00.75-.75V15.5m0-1.5c0-.414.336-.75.75-.75h.5c.414 0 .75.336.75.75v1c0 .414-.336.75-.75.75h-.5a.75.75 0 01-.75-.75v-1z" />
                            </svg>
                            <div>
                                <span class="font-medium text-gray-600 text-sm">Dimensiones:</span>
                                <p class="text-gray-900">
                                    {{ slabData.long }} {{ slabData.type_long }} x {{ slabData.width }} {{ slabData.type_width }}
                                </p>
                            </div>
                        </div>

                        <!-- Sección de Patologías -->
                        <div v-if="slabData.pathologies && slabData.pathologies.length > 0"
                             class="bg-gray-100 p-4 rounded-lg mt-4 border border-gray-200">
                            <p class="font-semibold text-gray-800 mb-3">Patologías ({{ slabData.pathologies.length }}):</p>
                            <ul class="list-none space-y-2 text-sm text-gray-700">
                                <li v-for="(pathology, index) in slabData.pathologies.slice(0, 5)" :key="index"
                                    class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-orange-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ pathology.name }}</span>
                                </li>
                                <li v-if="slabData.pathologies.length > 5" class="text-gray-500 mt-2">
                                    <span class="font-medium">+ {{ slabData.pathologies.length - 5 }} patologías más...</span>
                                </li>
                            </ul>
                        </div>
                        <p v-else class="text-gray-500 bg-gray-100 p-4 rounded-lg mt-4 border border-gray-200">No hay patologías registradas para esta placa.</p>
                    </div>
                    <div v-else class="text-center text-gray-500 p-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-lg">Cargando detalles de la placa...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// ... (tu script setup permanece igual) ...
import { Loader } from '@googlemaps/js-api-loader';
import { ref, onMounted, computed } from 'vue';
import { useProjectStore } from '../../store/projectStore';

const GOOGLE_MAPS_API_KEY = 'AIzaSyDwDGo35eOfpvz8g6zn8AGV2Sli49YowqY'; // Asegúrate de que esta es tu clave correcta.
const projectStore = useProjectStore();
const map = ref(null);
const mapDiv = ref(null);
const marker = ref(null);

const slabData = computed(() => projectStore.slabSelected);
const initialLatitude = computed(() => parseFloat(slabData.value?.latitude));
const initialLongitude = computed(() => parseFloat(slabData.value?.longitude));

const emit = defineEmits(['close']);

const initMap = async () => {
    if (!slabData.value || isNaN(initialLatitude.value) || isNaN(initialLongitude.value)) {
        console.warn("Datos de la losa o coordenadas no disponibles para la inicialización del mapa.");
        return;
    }

    const loader = new Loader({ apiKey: GOOGLE_MAPS_API_KEY });
    await loader.load();

    const position = { lat: initialLatitude.value, lng: initialLongitude.value };
    map.value = new google.maps.Map(mapDiv.value, {
        center: position,
        zoom: 18,
        fullscreenControl: true,
        streetViewControl: true,
        mapTypeControl: true,
    });

    marker.value = new google.maps.Marker({
        position: position,
        map: map.value,
        title: `Placa ID: ${slabData.value.id}`,
    });
};

const closeModal = () => {
    emit('close');
};

onMounted(() => {
    initMap();
});
</script>
