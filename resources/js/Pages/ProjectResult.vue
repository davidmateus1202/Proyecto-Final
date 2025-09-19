<template>
    <div v-if="projectStore.projectDetailsPublic.abscisas?.length > 0"
        class="flex flex-col items-center justify-center w-full h-auto">
        <!-- CÓDIGO MEJORADO PARA EL BANNER -->
        <div class="relative w-full h-[500px] md:h-[600px] overflow-hidden text-white">

            <!-- 1. Imagen de Fondo -->
            <img :src="fondoUrl" @error="setFallbackFondo" alt="image_project"
                class="absolute inset-0 w-full h-full object-cover z-0" />

            <!-- 2. Gradiente Inteligente para Legibilidad -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent z-10"></div>

            <!-- 3. Contenedor del Texto (con animación) -->
            <div class="relative z-20 h-full flex flex-col justify-end p-6 sm:p-12 md:p-24 pb-12 md:pb-20">

                <!-- Contenedor para aplicar la animación en cascada -->
                <div class="animate-fade-in-up flex flex-col gap-y-4 items-start">

                    <!-- Título Principal -->
                    <h1 class="text-5xl md:text-7xl font-bold tracking-tighter" style="animation-delay: 0.2s;">
                        {{ projectStore.projectDetailsPublic.name }}
                    </h1>

                    <!-- Descripción -->
                    <p class="text-lg md:text-xl text-white/80 max-w-lg" style="animation-delay: 0.4s;">
                        {{ projectStore.projectDetailsPublic.description }}
                    </p>

                    <!-- Tag con efecto Vidrio -->
                    <div class="mt-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full px-4 py-2 text-sm font-medium"
                        style="animation-delay: 0.6s;">
                        <span>Pavimento Rígido</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full h-auto p-12 md:p-32 xl:p-52">
            <h1 class="text-2xl sm:text-4xl font-bold">Estadisticas del estudio</h1>
            <span class="text-gray-600 text-sm sm:text-base">Detalles del estudio con base en la recolección de datos
                obtenidos.</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-10 mt-4">
                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconChartCovariate stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">{{ countAbscisas }} Abscisas</h1>
                    <p class="text-gray-600 text-sm mt-4">El tramo objeto de inspección contó con un total
                        de {{ countAbscisas }} abscisas registradas, las cuales fueron distribuidas a lo largo de su
                        recorrido.</p>
                </div>

                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconCards stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">{{ countPlacas }} Placas</h1>
                    <p class="text-gray-600 text-sm mt-4">El tramo objeto de inspección contó con un total
                        de {{ countPlacas }} placas registradas, distribuidas a lo largo de su recorrido.</p>
                </div>

                <div class="flex flex-col items-start justify-start">
                    <div class="flex w-14 h-14 bg-gray-200 rounded-full items-center justify-center">
                        <IconAlertTriangle stroke={1} />
                    </div>
                    <h1 class="text-gray-800 font-semibold mt-4">{{ countPatologias }} Patologias</h1>
                    <p class="text-gray-600 text-sm mt-4">Durante la inspección se registraron las patologías presentes
                        a lo largo del tramo, lo que permitió asociarlas al número de placas evaluadas.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full h-auto items-center justify-start px-12 md:px-32 xl:px-52 mt-[130px] md:mt-0">
            <h1 class="text-2xl sm:text-4xl font-bold">Estadisticas del estudio</h1>
            <span class="text-gray-600 text-sm sm:text-base">Detalles del estudio con base en la recolección de datos
                obtenidos.</span>
            <div class="flex flex-col lg:flex-row justify-center items-center my-10 gap-x-10 w-full">
                <CarruselAbscisa @abscisaSelected="updateSlabsForAbscisa"
                    :data="projectStore.projectDetailsPublic.abscisas" />
                <div ref="containersGrid" class="w-full lg:w-1/2 h-full grid grid-cols-1 gap-4 lg:grid-cols-2">

                    <div v-for="(slab, index) in containers" :key="slab.id" ref="containerRefs" :class="[
                        'group relative w-full h-[280px] rounded-2xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl p-5 flex flex-col justify-between overflow-hidden',
                        getContainerClasses(index) // Esto aplica su fondo degradado que ya tenía
                    ]">

                        <!-- Capa de efecto Vidrio Oscuro -->
                        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm z-0"></div>

                        <!-- Contenido de la tarjeta (encima del efecto vidrio) -->
                        <div class="relative z-10 flex flex-col h-full">

                            <!-- 1. Cabecera: ID y # de Patologías -->
                            <header class="flex justify-between items-start">
                                <div>
                                    <span class="text-sm font-light text-white/70">Placa</span>
                                    <h2 class="text-4xl font-bold text-white -mt-1">{{ slab.id }}</h2>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg"
                                    :class="slab.pathologies.length > 0 ? 'bg-amber-500/20' : 'bg-green-500/20'">
                                    <IconAlertTriangle v-if="slab.pathologies.length > 0"
                                        class="w-5 h-5 text-amber-400" />
                                    <IconShieldCheck v-else class="w-5 h-5 text-green-400" />
                                    <span class="font-semibold"
                                        :class="slab.pathologies.length > 0 ? 'text-amber-300' : 'text-green-300'">
                                        {{ slab.pathologies.length }}
                                    </span>
                                </div>
                            </header>

                            <!-- 2. Cuerpo: Detalles con Íconos -->
                            <div class="mt-4 flex-grow flex flex-col gap-2 text-white/90">
                                <!-- Dimensiones -->
                                <div class="flex items-center gap-3">
                                    <IconRulerMeasure class="w-5 h-5 text-white/50" />
                                    <span class="text-sm">{{ slab.long }} {{ slab.type_long }} x {{ slab.width }} {{
                                        slab.type_width }}</span>
                                </div>
                                <!-- Coordenadas -->
                                <div class="flex items-center gap-3">
                                    <IconMapPin class="w-5 h-5 text-white/50" />
                                    <span class="text-sm">{{ parseFloat(slab.latitude).toFixed(4) }}, {{
                                        parseFloat(slab.longitude).toFixed(4) }}</span>
                                </div>
                                <!-- Fecha de Creación -->
                                <div class="flex items-center gap-3">
                                    <IconCalendar class="w-5 h-5 text-white/50" />
                                    <span class="text-sm">{{ new Date(slab.created_at).toLocaleDateString() }}</span>
                                </div>
                            </div>

                            <!-- 3. Pie: Botón que aparece en Hover -->
                            <footer class="mt-auto">
                                <button
                                    @click="setNewPathologies(slab.pathologies)"
                                    class="w-full bg-white/10 hover:bg-white/20 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0">
                                    Ver Detalles
                                </button>
                            </footer>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="slide-up">
            <div 
                v-if="selectPathologies.length > 0" 
                class="flex flex-col w-full h-auto px-12 md:px-32 xl:px-52 mt-0 lg:mt-[100px]"
                ref="pathologiesSection"
                >
                <h1 class="text-2xl sm:text-4xl font-bold">Patologias</h1>
                <span class="text-gray-600 text-sm sm:text-base">Detalles sobre las patologias pertenecientes a cada placa.</span>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 w-full h-auto gap-3 mt-10">
                    <img v-for="(item, index) in selectPathologies.slice(0,5)" :key="index"  :src="item.url_image" alt="" class="w-full object-cover aspect-square hover:scale-95 transition-transform duration-300 ease-in-out cursor-pointer rounded-2xl">    
                    <div class="aspect-square flex flex-col items-center justify-center gap-y-4 cursor-pointer">
                        <div class="flex items-center justify-center bg-gray-200 rounded-full aspect-square shadow-2xl">
                            <h1 class="font-bold text-6xl text-gray-700 m-10">+{{ selectPathologies.length - 5 }}</h1>
                        </div>
                        <span class="text-gray-700 font-semibold text-2xl">Resultados de patologias</span>
                        <span class="text-gray-600 font-light text-sm">Da click aqui para ver mas resultados</span>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
    <Error v-else />
    <Loading v-if="showLoadingScreen" :is-actually-loading="!allComponentsReady" />
</template>

<script setup>
import { IconChartCovariate } from '@tabler/icons-vue';
import { IconCards } from '@tabler/icons-vue';
import { IconAlertTriangle } from '@tabler/icons-vue';
import CarruselAbscisa from '../Components/CarruselAbscisa.vue';
import { nextTick, onMounted, ref } from 'vue';
import Loading from './Loading.vue';
import { useProjectStore } from '../store/projectStore';
import { useRoute } from 'vue-router';
import Error from '../Error/Error.vue';
import { IconRulerMeasure, IconMapPin, IconCalendar, IconShieldCheck } from '@tabler/icons-vue';

const projectStore = useProjectStore();
const route = useRoute();
const countAbscisas = ref(0);
const countPlacas = ref(0);
const countPatologias = ref(0);

const containerRefs = ref([]);
const containersGrid = ref(null);
const isAnimating = ref(false);
const allComponentsReady = ref(false)
const showLoadingScreen = ref(true)
const fondoUrl = ref('');
const selectPathologies = ref('');
const pathologiesSection = ref(null)

const FADE_OUT_DURATION_LOADING_ELEMENTS = 0.2;
const EXPANSION_DURATION_LOADING = 0.7;

const containers = ref([]);

onMounted(async () => {
    showLoadingScreen.value = true;
    allComponentsReady.value = false;

    await handleData();

    if (projectStore.projectDetailsPublic.abscisas?.length > 0) {
        updateSlabsForAbscisa(0);
    }

    allComponentsReady.value = true;
    const totalLoadingTransitionTime = FADE_OUT_DURATION_LOADING_ELEMENTS + EXPANSION_DURATION_LOADING;
    setTimeout(() => {
        showLoadingScreen.value = false;
    }, (totalLoadingTransitionTime * 1000) + 100);
})

const getContainerClasses = (index) => {
    const baseColors = [
        'bg-gradient-to-br from-white to-black',
        'bg-gradient-to-br from-white to-black',
        'bg-gradient-to-br from-white to-black',
        'bg-gradient-to-br from-white to-black',
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

const updateSlabsForAbscisa = (index) => {
    // 1. Buscamos la abscisa seleccionada usando el índice que nos llega
    const selectedAbscisa = projectStore.projectDetailsPublic.abscisas[index];

    // 2. Verificamos que exista y que tenga placas
    if (selectedAbscisa && selectedAbscisa.slabs_with_pathologies) {
        // 3. Actualizamos 'containers' SOLO con las placas de esa abscisa
        containers.value = selectedAbscisa.slabs_with_pathologies.map(slab => ({
            ...slab,
            animated: false // Le agregamos el estado para la animación
        }));
    } else {
        // Si no hay placas, vaciamos el array
        containers.value = [];
    }

    // 4. Disparamos la animación para que las nuevas placas aparezcan de forma elegante
    handleCarouselClick();
};

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

const handleData = async () => {
    const projectId = route.params.id;
    await projectStore.getProjectDetailsPublic(projectId);
    fondoUrl.value = projectStore.projectDetailsPublic.url;

    projectStore.projectDetailsPublic.abscisas.forEach(abscisa => {
        countAbscisas.value++;
        countPlacas.value += abscisa.slabs_with_pathologies.length;
        abscisa.slabs_with_pathologies.forEach(slab => {
            countPatologias.value += slab.pathologies.length;
        })
    });
}

const setFallbackFondo = () => {
    fondoUrl.value = 'https://media.licdn.com/dms/image/v2/C5112AQEw1fXuabCTyQ/article-inline_image-shrink_1500_2232/article-inline_image-shrink_1500_2232/0/1581099611064?e=1762387200&v=beta&t=REpmuD079v2zeL6abmBTpKs3_aCCap9CjBPW6sJCYcE';
}

const setNewPathologies = async (pathologies) => {
    selectPathologies.value = pathologies;

    await nextTick();

    if (pathologiesSection.value) {
        const element = pathologiesSection.value;
        const offset = 50;
        const top = element.getBoundingClientRect().top + window.scrollY - offset;

        window.scrollTo({
            top,
            behavior: "smooth"
        })
    }
}

</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {

    /* Aplicamos la animación a los hijos para el efecto en cascada */
    &>* {
        opacity: 0;
        /* Empiezan invisibles */
        animation: fadeInUp 0.8s ease-out forwards;
    }
}

.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.4s ease;
}

.slide-up-enter-from {
    opacity: 0;
    transform: translateY(40px);
}

.slide-up-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.slide-up-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.slide-up-leave-to {
    opacity: 0;
    transform: translateY(40px);
}

</style>