<template>
    <div class="flex flex-col items-center justify-center w-full h-auto">
        <div class="relative md:hidden h-[500px] w-screen overflow-hidden">
            <div class="absolute inset-0 z-0 overflow-hidden">
                <img src="https://diapce-system.com.co/storage/images/jEllUI7ImzbFpQLmMkeaaJOgeMKkO1IOeWRmRjwv.jpg"
                    alt="image_project" class="w-full h-full object-cover" />
                >
            </div>
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
            <div class="relative z-10 flex flex-col items-start justify-center h-full px-5 sm:px-12">
                <h1 class="text-4xl sm:text-6xl font-bold text-white">Project Title</h1>
                <p class="mt-2 text-sm sm:text-lg text-white">Project description goes here.</p>
                <div class="mt-2 bg-white p-2 rounded-full px-4">
                    <span class="text-black">Pavimento rigido</span>
                </div>
            </div>
        </div>

        <div class="hidden md:flex w-full h-[500px] bg-gray-200 items-center justify-between pl-32 xl:pl-52">
            <div class="flex flex-col">
                <h1 class="text-7xl font-bold">Project Title</h1>
                <span class="text-gray-600 mt-2">Project description goes here.</span>
            </div>
            <img src="https://diapce-system.com.co/storage/images/jEllUI7ImzbFpQLmMkeaaJOgeMKkO1IOeWRmRjwv.jpg" alt="image_project" class="w-full h-[500px] object-cover" style="clip-path: polygon(39% 0, 100% 0%, 100% 99%, 0% 100%);" />
        </div>

        <div class="flex flex-col w-full h-auto p-12 md:p-32 xl:p-52">
            <h1 class="text-2xl sm:text-4xl font-bold">Estadisticas del estudio</h1>
            <span class="text-gray-600 text-sm sm:text-base">Detalles del estudio con base en la recolección de datos obtenidos.</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-10 mt-4">
                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconChartCovariate stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">14 Abscisas</h1>
                    <p class="text-gray-600 text-sm mt-4">El tramo objeto de inspección contó con un total
                        de 14 abscisas registradas, las cuales fueron distribuidas a lo largo de su recorrido.</p>
                </div>

                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconCards stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">14 Placas</h1>
                    <p class="text-gray-600 text-sm mt-4">El tramo objeto de inspección contó con un total
                        de 14 placas registradas, distribuidas a lo largo de su recorrido.</p>
                </div>

                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconAlertTriangle stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">14 Patologias</h1>
                    <p class="text-gray-600 text-sm mt-4">Durante la inspección se registraron las patologías presentes
                        a lo largo del tramo, lo que permitió asociarlas al número de placas evaluadas.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full h-auto items-center justify-start px-12 md:px-32 xl:px-52">
            <h1 class="text-2xl sm:text-4xl font-bold">Estadisticas del estudio</h1>
            <span class="text-gray-600 text-sm sm:text-base">Detalles del estudio con base en la recolección de datos obtenidos.</span>
            <div class="w-full flex flex-col md:flex-row justify-center mt-10 gap-x-10">
                <CarruselAbscisa @click="handleCarouselClick" />
                <div ref="containersGrid" class="w-full md:w-1/2 h-full grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div v-for="(container, index) in containers"
                        :key="index"
                        ref="containerRefs"
                        :class="[
                            'w-full h-[250px] rounded-3xl shadow-xl flex items-center justify-center text-white font-bold text-xl transition-all duration-500',
                            getContainerClasses(index)
                        ]"    
                    >

                    </div>
                </div>
            </div>
        </div>
    </div>
    <Loading v-if="showLoadingScreen" :is-actually-loading="!allComponentsReady" />
</template>

<script setup>
import { IconChartCovariate } from '@tabler/icons-vue';
import { IconCards } from '@tabler/icons-vue';
import { IconAlertTriangle } from '@tabler/icons-vue';
import CarruselAbscisa from '../Components/CarruselAbscisa.vue';
import { onMounted, ref } from 'vue';
import Loading from './Loading.vue';

const containerRefs = ref([]);
const containersGrid = ref(null);
const isAnimating = ref(false);
const allComponentsReady = ref(false)
const showLoadingScreen = ref(true)

const FADE_OUT_DURATION_LOADING_ELEMENTS = 0.2;
const EXPANSION_DURATION_LOADING = 0.7;

const containers = ref([
    { description: 'Análisis principal', animated: false },
    { description: 'Datos secundarios', animated: false },
    { description: 'Estadísticas', animated: false },
    { description: 'Resultados', animated: false }
]);

onMounted(async() => {
    showLoadingScreen.value = true;
    allComponentsReady.value = false;
    console.log("HomePage: Montado, iniciando carga simulada...");
    await new Promise(resolve => setTimeout(resolve, 3500));

    console.log("HomePage: Carga de componentes/datos terminada.");
    allComponentsReady.value = true; 

    const totalLoadingTransitionTime = FADE_OUT_DURATION_LOADING_ELEMENTS + EXPANSION_DURATION_LOADING;

    setTimeout(() => {
        console.log("HomePage: Ocultando pantalla de carga.");
        showLoadingScreen.value = false; // Desmonta Loading.vue y muestra el contenido
    }, (totalLoadingTransitionTime * 1000) + 100); // Multiplicar por 1000 para ms y añadir un pequeño buffer (100ms)

    handleCarouselClick();
}) 

const getContainerClasses = (index) => {
    const baseColors = [
        'bg-gradient-to-br from-blue-500 to-blue-700',
        'bg-gradient-to-br from-purple-500 to-purple-700', 
        'bg-gradient-to-br from-green-500 to-green-700',
        'bg-gradient-to-br from-red-500 to-red-700'
    ];

    const container = containers.value[index];
    let classes = [baseColors[index % baseColors.length]];

    if (!container.animated) {
        classes.push('opacity-0', 'scale-0');
    } else {
        classes.push('opacity-100', 'translate-y-0', 'translate-x-0', 'scale-100', 'rotate-y-0');
    }

    return classes;
}

const handleCarouselClick = () => {
    if (isAnimating.value) return;
    
    isAnimating.value = true;
    resetContainers();
    
    setTimeout(() => {
        animateBounce();
    }, 100);
};

const animateBounce = () => {
    containers.value.forEach((container, index) => {
        setTimeout(() => {
            container.animated = true;
        }, index * 180);
    });
    
    setTimeout(() => {
        isAnimating.value = false;
    }, containers.value.length * 180 + 600);
};

const resetContainers = () => {
    containers.value.forEach(container => {
        container.animated = false;
    });
};

</script>