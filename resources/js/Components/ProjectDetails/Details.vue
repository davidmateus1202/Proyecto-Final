<template>
    <div v-if="isLoading === false" class="flex flex-col w-full h-auto items-start justify-start gap-y-5">
        <h1 class="text-gray-600 font-bold text-sm md:text-lg lg:text-xl">Información adicional sobre la abscisa</h1>
        <span class="text-xs text-gray-400 mb-3">Información adicional sobre la abscisa seleccionada, incluyendo el área
            afectada y la superficie conservada en estado saludable.</span>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full h-auto">
            <!-- grafic 1 -->
            <div class="flex-1 flex bg-gray-50 rounded-3xl p-5 max-h-80">
                <GraficView v-if="projectStore.chart.length > 0" />
                <div v-else class="flex flex-col items-center justify-center w-full h-full">
                    <img :src="icon9" class="w-20 h-20" />
                    <h1 class="font-bold text-gray-600 mt-4">No se encontraron datos</h1>
                    <span class="text-xs lg:max-w-80 text-center text-gray-400">No se encontraron datos para la
                        gráfica.</span>

                </div>
            </div>
            <div class="flex-1 mt-14 md:mt-0 flex flex-col p-5 items-center justify-center max-h-80">
                <PieGraficView />
                <h1 class="font-bold text-gray-600 mt-4">Relación del área afectada</h1>
                <span class="text-xs lg:max-w-80 text-center text-gray-400">Análisis proporcional del área afectada en
                    relación con la superficie conservada en estado saludable.</span>
            </div>
        </div>

        <!-- tabla de registro de datos pantallas grandes -->
        <div class="flex flex-col w-full h-auto shadow-sm p-5 rounded-lg mt-5">
            <div class="flex w-full h-auto justify-between items-center">
                <div class="flex items-center gap-x-2">
                    <h1 class="text-secondary font-bold">{{ projectStore.placaSelectedId !== null ? `Placa -
                        ${projectStore.placaSelectedId}` : 'Patologias detectadas' }}</h1>
                    <div v-if="projectStore.placaSelectedId !== null"
                        @click="toogleMap"
                        class="flex bg-gray-100 w-8 h-8 rounded-full items-center justify-center shadow-sm cursor-pointer hover:bg-gray-200">
                        <i class="pi pi-map"></i>
                    </div>
                </div>
                <button ref="filterButton" @click="toggleFilterDropdown"
                    class="flex items-center gap-x-2 bg-gray-100 rounded-3xl px-5 py-2 shadow-sm hover:bg-gray-200">
                    <i class="pi pi-filter"></i>
                    <h1>{{ projectStore.placaSelectedId !== null ? `Placa - ${projectStore.placaSelectedId}` : 'Filtros' }}</h1>
                </button>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2"></div>

            <div v-if="projectStore.pathologies.length > 0" class="hidden md:flex w-full h-auto items-center justify-center">
                <table class="w-full h-auto">
                    <thead>
                        <tr>
                            <th class="text-gray-500 border-b py-2 text-start">Ingeniero</th>
                            <th class="text-gray-500 border-b py-2 text-center">Patologia</th>
                            <th class="text-gray-500 border-b py-2 text-center">Tipo</th>
                            <th class="text-gray-500 border-b py-2 text-center">Mas datos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(pathology, index) in projectStore.pathologies" :key="index">
                            <td class="flex h-auto p-3 justify-start gap-x-3">
                                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                                    class="w-10 h-10 rounded-full" />
                                <div class="flex flex-col items-start">
                                    <h1>{{ user.user.name }}</h1>
                                    <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="text-[12px] xl:text-[14px] font-semibold text-gray-500">{{ pathology.name }}</span>
                            </td>

                            <td class="text-center">
                                <div class="flex w-full h-full items-center justify-center">
                                    <div :class="{ [formattedDamageClass(pathology.type_damage)]: true }">
                                        <span class="text-sm font-semibold">{{ formattedDamage(pathology.type_damage) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="flex items-center justify-center">
                                <div
                                    class="flex w-8 h-8 bg-gray-100 items-center justify-center mb-5 rounded-full shadow-sm cursor-pointer hover:bg-gray-200">
                                    <i class="pi pi-angle-down"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="projectStore.pathologies.length > 0" class="flex md:hidden w-full h-auto items-center justify-center">
                <table class="w-full h-auto mt-4">
                    <thead>
                        <tr>
                            <th class="text-gray-500 border-b py-2 text-start">Ingeniero</th>
                            <th class="text-gray-500 border-b py-2 text-center">Más datos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(pathology, index) in projectStore.pathologies" :key="index">
                            <td class="flex h-auto p-3 justify-start gap-x-3">
                                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                                    class="w-10 h-10 rounded-full" />
                                <div class="flex flex-col items-start">
                                    <h1>{{ user.user.name }}</h1>
                                    <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                                </div>
                            </td>

                            <td class="text-center">
                            <div class="flex w-full h-full items-center justify-center">
                                    <div class="flex w-8 h-8 bg-gray-100 items-center justify-center mb-5 rounded-full shadow-sm cursor-pointer hover:bg-gray-200">
                                        <i class="pi pi-angle-down"></i>
                                    </div>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="projectStore.pathologies.length === 0" class="flex flex-col items-center justify-center mt-10">
                <img :src="icon8" class="w-20 h-20" />
                <h1 class="font-bold text-gray-600 mt-4">No se encontraron patologías</h1>
                <span class="text-xs lg:max-w-80 text-center text-gray-400">No se encontraron patologías en la placa
                    seleccionada.</span>

            </div>
            
        </div>

    </div>

    <div v-else class="flex flex-col w-full h-full items-center justify-center">
        <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
        <h1 class="font-bold text-black">Cargando...</h1>

    </div>

    <!-- Dropdown or modals -->
    <FilterDropdown v-if="showFilter" :position="position" @close="closeDropdown" />
    <AlertError v-if="isErrorMessage" class="absolute top-0 left-0 right-0 mx-auto w-96"/>
    <ModalGoogleMaps v-if="showMap" @close="toogleMap" />



</template>

<script setup>

import GraficView from './GraficView.vue';
import PieGraficView from './PieGraficView.vue';
import { onMounted, ref, nextTick, onUnmounted } from 'vue';
import { useProjectStore } from '../../store/projectStore';
import { useAuthStore } from '../../store/authStore';
import FilterDropdown from './FilterDropdown.vue';
import icon8 from '../../assets/icon8.png';
import icon9 from '../../assets/icon9.png';
import AlertError from '../Alert/AlertError.vue';
import ModalGoogleMaps from './ModalGoogleMaps.vue';

const projectStore = useProjectStore()
const isLoading = ref(false);
const user = useAuthStore();
const filterButton = ref(null);
const position = ref({ top: 0, left: 0 });
const showFilter = ref(false);
const isErrorMessage = ref(false);
const showMap = ref(false);


onMounted(async () => {
    isLoading.value = true;
    await projectStore.getChartAbscisaDetails(projectStore.abscisaSelected.id);
    if (projectStore.abscisaSelected.slabs_with_pathologies.length > 0) {
        projectStore.setPlacaSelectedId(projectStore.abscisaSelected.slabs_with_pathologies[0].id);
    } else {
        projectStore.pathologies = [];
        projectStore.setPlacaSelectedId(null);
    }
    isLoading.value = false;

    window.addEventListener('resize', handleResize);
})

const formattedArea = (longSize, widthSize) => {
    longSize = longSize / 100;
    widthSize = widthSize / 100;
    const area = longSize * widthSize;
    return area + ' m²'; // Formatear a dos decimales y agregar la unidad
}

const toggleFilterDropdown = async () => {
    nextTick(() => {
        // Verifica si el botón de filtro está visible
        if (projectStore.abscisaSelected.slabs_with_pathologies.length === 0) {
            isErrorMessage.value = true;
            setTimeout(() => {
                isErrorMessage.value = false;
            }, 3000);
            return;
        }

        if (filterButton.value) {
            // Verifica las dimensiones del botón
            const positionValue = filterButton.value.getBoundingClientRect();
            console.log(positionValue); // Verifica las coordenadas
            position.value = {
                top: positionValue.bottom + window.scrollY + 8,
                left: positionValue.left + window.scrollX - 150
            };
            showFilter.value = !showFilter.value;
        } else {
            console.log("El botón de filtro no está visible");
        }
    });
};

const handleResize = () => {
    if (showFilter.value) {
        showFilter.value = false;
    }
}


const closeDropdown = () => {
    showFilter.value = false;
}

const toogleMap = () => {
    showMap.value = !showMap.value;
}

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});

const formattedDamage = (damage) => {
    switch (damage) {
        case 'half':
            return 'Media';
        case 'low':
            return 'Baja';
        case 'high':
            return 'Alta';
        case 'none':
            return 'Ninguna';
        default:
            return 'Desconocida';
    }
}

const formattedDamageClass = (damage) => {
    switch (damage) {
        case 'half':
            return 'flex items-center justify-center bg-yellow-200 w-20 h-8 rounded-full shadow-sm border-2 border-yellow-300';
        case 'low':
            return 'flex items-center justify-center bg-green-200 w-20 h-8 rounded-full shadow-sm border-2 border-green-300';
        case 'high':
            return 'flex items-center justify-center bg-red-300 w-20 h-8 rounded-full shadow-sm border-2 border-red-500';
        case 'none':
            return 'flex items-center justify-center bg-gray-200 w-20 h-8 rounded-full shadow-sm border-2 border-gray-300';
        default:
            return 'flex items-center justify-center bg-gray-200 w-20 h-8 rounded-full shadow-sm border-2 border-gray-300';
    }
}

</script>