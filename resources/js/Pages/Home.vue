<template>
    <div class="flex flex-col w-full h-screen p-5 gap-y-5 overflow-y-auto">
        <header class="flex w-full h-auto items-end justify-between">
            <h1 class="text-secondary font-extrabold">DB</h1>
            <!-- profile user -->
            <div class="flex items-center gap-x-3">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg"
                    class="w-10 rounded-full">
                <span class="hidden lg:block font-bold text-gray-700">{{ auth.user.email }}</span>
                <button 
                @click="activate"
                class="block lg:hidden hover:bg-primary rounded-md p-2">
                    <i class="pi pi-chevron-right text-black"></i>
                </button>
            </div>
        </header>
        <div class="w-full h-1 bg-gray-200 rounded-3xl shadow-md my-2 text-white">.</div>


        <div class="flex w-full h-full justify-between">
            <!-- section 1 -->
            <div class="flex-col w-full lg:w-[75%] h-full items-start justify-start gap-y-3 px-5" 
            :class="{
                'flex' : !isActivated,
                'hidden lg:flex' : isActivated
            }">
                <h1 class="text-primary font-bold text-xl">DB - Analisis de Datos</h1>
                <span class="text-gray-400">Patologias</span>

                <!-- section de patologias -->
                <div class="w-full min-h-60 h-auto flex overflow-x-auto gap-x-10 hide-scrollbar">
                    <section class="flex flex-col min-w-[14rem] w-56 h-56 items-start justify-center rounded-xl gap-y-2">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTo-jzHHYNJ_1rckxebAiNtNrn5gDpgiHTy42p0djrIxEakrkCUyGceoXbt_FwZx_So6bM&usqp=CAU"
                        class="rounded-xl shadow-md">
                        <h1 class="text-secondary font-bold text-ellipsis">Piel de cocodrilo</h1>
                    </section>
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
                                    <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full">
                                    <div class="flex flex-col items-start">
                                        <h1>Yuly Paola Gonzalez</h1>
                                        <span class="text-gray-400 font-extralight text-sm">Ingeniero Civil</span>
                                    </div>
                                </th>
                                <th>
                                    <span class="text-gray-400">12/12/2021</span>
                                </th>
                                <th>
                                    <span class="bg-green-200 p-3 rounded-xl border-2 border-green-500 text-green-500">Actualizacion</span>
                                </th>
                                <th>
                                    <span class="text-gray-400 font">Piel de cocodrilo</span>
                                </th>
                            </tr>

                        </tbody>
                    </table>
                 </div>

            </div>

            <!-- section 1 -->
            <div class="flex-col w-full lg:w-[25%] h-[95%] items-center justify-start gap-y-3 bg-white lg:bg-black p-5 rounded-xl"
            :class="{
                'flex' : isActivated,
                'hidden lg:flex' : !isActivated
            }">

                <!-- Numero de patologias -->
                <h1 class="text-primary font-bold text-sm self-start">Resultados</h1>
                <div class="w-full h-0.5 bg-gray-200 rounded-3xl shadow-md"></div>
                <div class="flex items-center justify-center border-4 border-primary w-52 h-52 rounded-full bg-gray-900 my-5">
                    <div class="flex flex-col items-center justify-center bg-gray-800 w-44 h-44 rounded-full shadow-md">
                        <h1 class="text-white font-extralight text-5xl">80</h1>
                        <span class="text-white">Patologias</span>
                    </div>
                </div>

                <!-- detalles de patologias -->
                 <div class="self-start flex items-center justify-center gap-x-3">
                    <img :src="icon4" class="w-10 bg-primary p-1 rounded-lg">
                    <h1 class="text-gray-700 lg:text-white">10 Huecos</h1>
                 </div>

                 <div class="self-start flex items-center justify-center gap-x-3">
                    <img :src="icon4" class="w-10 bg-primary p-1 rounded-lg">
                    <h1 class="text-gray-700 lg:text-white">10 Huecos</h1>
                 </div>

                 <div class="self-start flex items-center justify-center gap-x-3">
                    <img :src="icon4" class="w-10 bg-primary p-1 rounded-lg">
                    <h1 class="text-gray-700 lg:text-white">10 Huecos</h1>
                 </div>
                
            </div>
        </div>

    </div>
</template>

<script setup>

// data
import { useAuthStore } from '../store/authStore';
import { ref } from 'vue';
import FeedBack from '../Components/FeedBack.vue';

import icon4 from '../assets/icon4.png';

// variables
const auth = useAuthStore();
const isActivated = ref(false);

const activate = () => {
    isActivated.value = !isActivated.value;
}

</script>