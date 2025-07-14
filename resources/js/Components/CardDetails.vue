<template>
    <div class="flex flex-col top-0 w-full h-auto items-center justify-center">
        <div class="flex w-32 h-32 bg-secondary rounded-full z-10 items-center justify-center">
            <div class="flex items-center justify-center w-full h-28 bg-white rounded-full translate-y-2">
                <img :src="props.image" class="w-16 h-16">
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full h-full bg-white p-5 rounded-xl translate-y-[-80px]">
            <h1 class="text-lg text-center font-semibold mt-20">{{ props.title }}</h1>
            <p class="text-center mt-5 text-sm">{{ props.description }}</p>
        </div>
    </div>

</template>

<script setup>
import { defineProps } from 'vue';
import icon3 from '../assets/icon3.png';

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Titulo por defecto',
    },
    description: {
        type: String,
        required: true,
        default: 'Descripcion por defecto',
    },
    image: {
        type: String,
        required: true,
        default: icon3,
    },
})

</script> 