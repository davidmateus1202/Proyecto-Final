<template>
    <div class="flex flex-col w-full h-screen p-5 gap-y-5">
        <header class="flex w-full h-auto items-end justify-between">
            <button v-if="isActivated === true" @click="activate" class="block lg:hidden hover:bg-primary rounded-md p-2">
                <i class="pi pi-chevron-right text-black rotate-180"></i>
            </button>
            <h1 class="text-secondary font-extrabold">DB</h1>
            <!-- profile user -->
            <div class="flex items-center gap-x-3">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                    class="w-10 rounded-full">
                <span class="hidden lg:block font-bold text-gray-700">{{ auth.user.email }}</span>
            </div>
        </header>
        <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2 text-white">.</div>


        <div class="flex w-full h-screen justify-between overflow-hidden">

            <!-- section 1 -->
            <div class="flex-col w-full lg:w-[30%] lg:min-w-[30%] h-[95%] items-start justify-start gap-y-3 bg-white p-5 overflow-y-auto hide-scrollbar"
                :class="{
                    'flex': !isActivated,
                    'hidden lg:flex': isActivated
                }">

                <!-- search -->
                 <div class="flex w-full rounded-lg bg-gray-100 px-5 py-3 items-center gap-x-4">
                    <i class="pi pi-search text-gray-400"></i>
                    <input class="w-full h-auto bg-transparent outline-none " type="text" placeholder="Buscar">
                 </div>

                 <h3 class="font-semibold text-gray-500">Proyectos</h3>

                 <!-- item by project -->
                 <div @click="changeId(project.id)" v-if="projects.loading === false && projects.project.length !== 0" v-for="(project, index) in projects.project" :key="index" class="flex flex-col w-full h-auto rounded-md cursor-pointer">
                    <img :src="project.url" class="w-full h-52 object-cover rounded-lg">
                    <h3 class="font-semibold text-gray-500 text-lg mt-4">{{ project.name }}</h3>
                    <span class="font-extralight text-gray-400 text-[14px]">{{ project.description }}</span>
                 </div>

                 <div v-else-if="projects.loading === true" class="flex w-full h-full items-center justify-center">
                    <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
                 </div>

                 <div v-if="projects.project.length === 0 && projects.loading === false" class="flex flex-col w-full h-full items-center justify-center">
                    <img :src="icon4" class="w-20 h-20 object-cover">
                    <h1 class="text-gray-800 font-semibold mt-3">No se encontraron resultados!</h1>
                    <span class="font-extralight text-xs text-gray-600">No tienes proyectos creados en este momento.</span>
                 </div>
            </div>

            <!-- section - 2 -->
             <ProjectDetails :isActivated="isActivated" :projectId="projectId" />
        </div>

    </div>
</template>

<script setup>

// components
import ProjectDetails from './ProjectDetails.vue';

// data
import { useAuthStore } from '../store/authStore';
import { useProjectStore } from '../store/projectStore';
import { onBeforeMount, ref } from 'vue';
import icon4 from '../assets/icon4.png';

// variables
const auth = useAuthStore();
const projects = useProjectStore();
const isActivated = ref(false);
const projectId = ref(null);


const activate = () => {
    isActivated.value = !isActivated.value;
}

onBeforeMount( async () => {
    await projects.getProjects();
});

const changeId = (id) => {
    isActivated.value = true;
    projectId.value = id
}

</script>
