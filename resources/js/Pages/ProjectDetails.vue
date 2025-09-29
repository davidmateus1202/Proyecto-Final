<template>
    <!-- section 2 -->
    <div v-if="props.projectId !== null && projectStore.projectDetails.length > 0 && projectStore.projectDetailsLoading === false"
        class="flex-col w-[95%] lg:w-[70%] h-[98%] items-start justify-start gap-y-3 px-5 overflow-y-auto hide-scrollbar"
        :class="{
            'flex': props.isActivated,
            'hidden lg:flex': !props.isActivated
        }">
        <h1 class="text-primary font-bold text-xl">DB - Analisis de Datos</h1>
        <span class="text-gray-400">Abscisas</span>

        <!-- section de abscisas -->
        <OverlayScrollbarsComponent 
            :options="{ scrollbars: { autoHide: 'leave', theme: 'os-theme-dark' } }"
            class="w-full min-h-[160px] h-auto"
        >
            <div v-if="projectStore.projectDetails.length > 0"
            class="flex flex-row flex-nowrap gap-x-6 p-2">
            <div v-for="(project, index) in projectStore.projectDetails" :key="project.id"
                @click="selectAbscisa(project)" class="flex flex-col w-64 h-32 rounded-2xl bg-white shadow-md border border-gray-100 p-4 cursor-pointer 
         transition-transform duration-200 hover:shadow-md hover:scale-105">
                <!-- Header con número + nombre -->
                <div class="flex items-center gap-x-3">
                    <div class="flex w-12 h-12 rounded-full items-center justify-center font-bold text-lg shadow-sm"
                        :class="project.status === 'finished' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'">
                        {{ index + 1 }}
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-gray-800 font-semibold text-lg truncate">
                            {{ project.name }}
                        </span>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full w-fit mt-1"
                            :class="project.status === 'finished' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200'">
                            {{ formatStatus(project.status) }}
                        </span>
                    </div>
                </div>

                <!-- Info extra -->
                <div class="mt-3 flex justify-between items-center text-sm text-gray-500">
                    <div class="text-right">
                        <span class="block">🛠 {{ project.slabs_with_pathologies?.length || 0 }} placa(s)</span>
                    </div>
                </div>
            </div>

        </div>
        </OverlayScrollbarsComponent>

        <!-- navigation  -->
        <div class="flex flex-col w-full h-auto items-start justify-start">
            <div class="flex w-full h-auto gap-x-2">
                <div @click="selectedSection = 'register'" class="bg-gray-200 rounded-t-2xl cursor-pointer">
                    <h1 class="text-secondary font-bold my-2 mx-5 text-sm hover:text-black">Detalles de proyecto</h1>
                </div>

                <div @click="selectedSection = 'details'" v-if="projectStore.abscisaSelected !== null"
                    class="bg-gray-200 rounded-t-2xl cursor-pointer hover:transition-all duration-200">
                    <h1 class="text-secondary font-bold my-2 mx-5 text-sm hover:text-black">{{
                        projectStore.abscisaSelected.name }}</h1>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md"></div>
        </div>

        <!-- layout for details -->
        <div class="flex flex-col w-full h-full items-start justify-start">

            <component :is="selectView" />

        </div>
    </div>

    <div v-if="projectStore.projectDetailsLoading === true"
        class="flex flex-col w-full lg:w-[70%] h-[98%] items-center justify-center" :class="{
            'flex': props.isActivated,
            'hidden lg:flex': !props.isActivated
        }">
        <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
        <span class="font-semibold text-gray-700">Cargando..</span>
    </div>

    <div v-if="projectStore.projectDetails.length === 0 && projectStore.projectDetailsLoading === false"
        class="flex flex-col w-full lg:w-[70%] h-[98%] items-center justify-center" :class="{
            'flex': props.isActivated,
            'hidden lg:flex': !props.isActivated
        }">
        <img :src="icon7" class="w-20 h-20 object-cover">
        <h1 class="font-semibold text-gray-800 text-lg">No se encontraron resultados!</h1>
        <span class="font-extralight text-gray-400 text-sm">Selecciona o cambia de proyecto para encontrar nuevos
            resultados.</span>
    </div>
</template>

<script setup>

// components
import RegisterData from '../Components/ProjectDetails/RegisterData.vue';
import Details from '../Components/ProjectDetails/Details.vue';
import { OverlayScrollbarsComponent } from 'overlayscrollbars-vue';
import 'overlayscrollbars/styles/overlayscrollbars.css';

// store
import { useProjectStore } from '../store/projectStore';

// images
import icon7 from '../assets/icon7.png';
import { watch, defineProps, ref, computed, onMounted } from 'vue';

const selectedSection = ref('register');
const props = defineProps({
    isActivated: {
        type: Boolean,
        default: true
    },
    projectId: {
        type: Number,
        required: false,
        default: null
    }
})

const projectStore = useProjectStore();

watch(() => props.projectId, (newVal, oldVal) => {
    if (newVal !== oldVal && newVal !== null) {
        selectedSection.value = 'register';
        getProjectDetails(newVal);
    }
})

const getProjectDetails = async (val) => {
    await projectStore.getProjectDetails(val);
}

// fotmat status
const formatStatus = (status) => {
    switch (status) {
        case 'in_progress':
            return 'Proceso';
        case 'finished':
            return 'Finalizado';
        default:
            return 'No definido';
    }
}

// seleccionar una determinada abscisa
const selectAbscisa = (abscisa) => {
    selectedSection.value = 'register';
    projectStore.setAbscisaSelected(abscisa);
}

// seleccion de vista
const selectView = computed(() => {
    switch (selectedSection.value) {
        case 'details':
            return Details;
        case 'register':
            return RegisterData;
        default:
            return RegisterData;
    }
})

onMounted(() => {
    console.log(projectStore.projectDetails);
})

</script>