<template>
    <!-- section 2 -->
    <div v-if="props.projectId !== null" class="flex-col w-full lg:w-[70%] h-[98%] items-start justify-start gap-y-3 px-5 overflow-y-auto hide-scrollbar"
        :class="{
            'flex': props.isActivated,
            'hidden lg:flex': !props.isActivated
        }">
        <h1 class="text-primary font-bold text-xl">DB - Analisis de Datos</h1>
        <span class="text-gray-400">Abscisas</span>

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
</template>

<script setup>

// components
import FeedBack from '../Components/FeedBack.vue';
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

watch(() => props.projectId, (newVal, oldVal) => {
    if (newVal !== oldVal && newVal !== null) {
        getProjectDetails(newVal);
    }
})

const getProjectDetails = async (val) => {
    console.log('getProjectDetails', val);
}


</script>