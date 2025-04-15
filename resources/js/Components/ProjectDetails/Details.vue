<template>
    <div v-if="isLoading === false" class="flex flex-col w-full h-auto items-start justify-start gap-y-5">
        <h1 class="text-gray-600 font-bold text-sm md:text-lg lg:text-xl">Información adicional sobre la abscisa</h1>
        <span class="text-xs text-gray-400 mb-3">Información adicional sobre la abscisa seleccionada, incluyendo el área
            afectada y la superficie conservada en estado saludable.</span>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full h-auto">
            <!-- grafic 1 -->
            <div class="flex-1 flex bg-gray-50 rounded-3xl p-5 max-h-80">
                <GraficView />
            </div>
            <div class="flex-1 mt-14 md:mt-0 flex flex-col p-5 items-center justify-center max-h-80">
                <PieGraficView />
                <h1 class="font-bold text-gray-600 mt-4">Relación del área afectada</h1>
                <span class="text-xs lg:max-w-80 text-center text-gray-400">Análisis proporcional del área afectada en
                    relación con la superficie conservada en estado saludable.</span>
            </div>
        </div>

        <!-- tabla de registro de datos pantallas grnades -->
        <div class="hidden md:flex flex-col w-full h-auto shadow-sm p-5 rounded-lg mt-5">
            <h1 class="text-secondary font-bold">Registro de placas</h1>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2"></div>
            <table>
                <thead>
                    <tr>
                        <th class="text-gray-500 border-b py-2 text-start">Ingeniero</th>
                        <th class="text-gray-500 border-b py-2 text-center">Ubicacion</th>
                        <th class="text-gray-500 border-b py-2 text-center"># Patologias</th>
                        <th class="text-gray-500 border-b py-2 text-center">Area</th>
                        <th class="text-gray-500 border-b py-2 text-center">Mas datos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, index) in projectStore.projectDetails" :key="index">
                        <th class="flex h-auto p-3 justify-start gap-x-3">
                            <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                                class="w-10 h-10 rounded-full">
                            <div class="flex flex-col items-start">
                                <h1>{{ user.user.name }}</h1>
                                <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                            </div>
                        </th>
                        <th class="text-center">
                            <span class="text-sm">{{ project.slabs_with_pathologies[0].longitude}}, {{ project.slabs_with_pathologies[0].latitude }}</span>
                        </th>
                        <th class="text-center">
                           <span >{{ project.slabs_with_pathologies[0].pathologies.length }}</span>
                        </th>
                        <th class="text-center">
                            <span class="font-bold">{{ formattedArea(project.slabs_with_pathologies[0].long,  project.slabs_with_pathologies[0].width) }}</span>
                        </th>
                        <th class="flex items-center justify-center">
                            <div class="flex w-8 h-8 bg-gray-100 items-center justify-center mb-5 rounded-full shadow-sm cursor-pointer hover:bg-gray-200">
                               <i class="pi pi-angle-down"></i> 
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- tabla de registro de datos pantallas moviles -->
        <div class="flex md:hidden flex-col w-full h-auto shadow-sm p-5 rounded-lg mt-5">
            <h1 class="text-secondary font-bold">Registro de placas</h1>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2"></div>
            <table>
                <thead>
                    <tr>
                        <th class="text-gray-500 border-b py-2 text-start">Ingeniero</th>
                        <th class="text-gray-500 border-b py-2 text-center">Mas datos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, index) in projectStore.projectDetails" :key="index">
                        <th class="flex h-auto p-3 justify-start gap-x-3">
                            <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                                class="w-10 h-10 rounded-full">
                            <div class="flex flex-col items-start">
                                <h1>{{ user.user.name }}</h1>
                                <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex w-full h-full items-center justify-center">
                                <div class="flex w-8 h-8 bg-gray-100 items-center justify-center mb-5 rounded-full shadow-sm cursor-pointer hover:bg-gray-200">
                                    <i class="pi pi-angle-down"></i> 
                                </div>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-else class="flex flex-col w-full h-full items-center justify-center">
        <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
        <h1 class="font-bold text-black">Cargando...</h1>

    </div>
</template>

<script setup>

import GraficView from './GraficView.vue';
import PieGraficView from './PieGraficView.vue';
import { onMounted, ref } from 'vue';
import { useProjectStore } from '../../store/projectStore';
import { useAuthStore } from '../../store/authStore';

const projectStore = useProjectStore()
const isLoading = ref(false);
const user = useAuthStore();

onMounted(async() => {
    isLoading.value = true;
    await projectStore.getChartAbscisaDetails(projectStore.abscisaSelected.id);
    console.log(projectStore.projectDetails)
    isLoading.value = false;
})

const formattedArea = (longSize, widthSize) => {
    longSize = longSize / 100;
    widthSize = widthSize / 100;
    const area = longSize * widthSize;
    return area + ' m²'; // Formatear a dos decimales y agregar la unidad
}

</script>