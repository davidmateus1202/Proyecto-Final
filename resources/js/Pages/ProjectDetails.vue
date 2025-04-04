<template>
    <!-- section 2 -->
    <div v-if="props.projectId !== null && projectStore.projectDetails.length > 0 && projectStore.projectDetailsLoading === false" class="flex-col w-full lg:w-[70%] h-[98%] items-start justify-start gap-y-3 px-5 overflow-y-auto hide-scrollbar"
        :class="{
            'flex': props.isActivated,
            'hidden lg:flex': !props.isActivated
        }">
        <h1 class="text-primary font-bold text-xl">DB - Analisis de Datos</h1>
        <span class="text-gray-400">Abscisas</span>

        <!-- section de abscisas -->
        <div 
            v-if="projectStore.projectDetails.length > 0"
            class="flex flex-row w-full min-h-24 h-auto overflow-x-auto gap-x-10 hide-scrollbar flex-nowrap"
            >
            <section 
                v-for="(project, index) in projectStore.projectDetails" 
                :key="index" 
                class="flex flex-col min-w-56 w-auto h-24 items-start justify-center rounded-xl gap-y-2 bg-gray-50 border-x-gray-300 shadow-sm px-10 py-3 cursor-pointer"
            >
                <div class="flex flex-wrap w-full h-auto items-center justify-start gap-x-3">
                <div class="flex w-12 h-12 min-w-12 bg-white rounded-full items-center justify-center">
                    <h1 class="font-bold text-lg text-gray-700">{{ index + 1 }}</h1>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-700 font-bold text-ellipsis ">{{ project.name }}</span>
                    <span class="text-gray-400 font-semibold text-sm">{{ formatStatus(project.status) }}</span>
                </div>
                </div>
            </section>
            </div>

        <!-- navigation  -->
         <div class="flex flex-col w-full h-auto items-start justify-start my-5">
            <div class="flex w-full h-auto gap-x-2">
                <div class="bg-gray-200 rounded-t-md">
                    <h1 class="text-gray-400 font-bold m-2">Detalles de proyecto</h1>
                </div>
                
                <div class="bg-gray-200 rounded-t-md">
                    <h1 class="text-secondary font-bold m-2">Detalles de proyecto</h1>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md"></div>
         </div>


        <FeedBack />

        <!-- tabla de registro de datos -->
        <div class="flex flex-col w-full h-auto shadow-sm p-5 rounded-lg mt-5">
            <h1 class="text-secondary font-bold">Registro de patologias</h1>
            <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2"></div>
            <table>
                <thead>
                    <tr>
                        <th class="text-gray-500 border-b py-2">Ingeniero</th>
                        <th class="text-gray-500 border-b py-2">Fecha</th>
                        <th class="text-gray-500 border-b py-2">Accion</th>
                        <th class="text-gray-500 border-b py-2">Patologia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="flex  h-auto p-3 justify-start gap-x-3">
                            <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                                class="w-10 h-10 rounded-full">
                            <div class="flex flex-col items-start">
                                <h1>Yuly Paola Gonzalez</h1>
                                <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                            </div>
                        </th>
                        <th>
                            <span class="text-gray-400">12/12/2021</span>
                        </th>
                        <th>
                            <span
                                class="bg-green-200 p-3 rounded-xl border-2 border-green-500 text-green-500">Actualizacion</span>
                        </th>
                        <th>
                            <span class="text-gray-400 font">Piel de cocodrilo</span>
                        </th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div v-if="projectStore.projectDetailsLoading === true" class="flex flex-col w-full lg:w-[70%] h-[98%] items-center justify-center"
        :class="{
                'flex': props.isActivated,
                'hidden lg:flex': !props.isActivated
            }">
        <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
        <span class="font-semibold text-gray-700">Cargando..</span>
    </div>

    <div v-if="projectStore.projectDetails.length === 0 && projectStore.projectDetailsLoading === false" class="flex flex-col w-full lg:w-[70%] h-[98%] items-center justify-center"
        :class="{
                'flex': props.isActivated,
                'hidden lg:flex': !props.isActivated
            }">
        <img :src="icon7" class="w-20 h-20 object-cover">
        <h1 class="font-semibold text-gray-800 text-lg">No se encontraron resultados!</h1>
        <span class="font-extralight text-gray-400 text-sm">Selecciona o cambia de proyecto para encontrar nuevos resultados.</span>
    </div>
</template>

<script setup>

// components
import FeedBack from '../Components/FeedBack.vue';
import { useProjectStore } from '../store/projectStore';

// images
import icon7 from '../assets/icon7.png';

import { watch } from 'vue';
import { defineProps } from 'vue';

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
            return 'En proceso';
        case 'finished':
            return 'Finalizado';
        default:
            return 'No definido';
    }
}


</script>