<template>
    <div class="relative bg-blue-600 h-[500px] w-screen overflow-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img :src="fondo" class="object-cover w-full h-full" alt="Background Image">
        </div>
        <div class="absolute inset-0 bg-white opacity-50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-white to-transparent"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full">
            <h1 class="font-semibold text-4xl">{{ props.title }}</h1>
            <div class="flex items-center justify-center mt-5">
                <span class="font-extralight text-lg">Inicio</span>
                <IconChevronRight stroke={2} />
                <span class="font-extralight text-lg">{{ props.title }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import fondo from '../assets/fondo6.webp';
import { IconChevronRight } from '@tabler/icons-vue';
import { defineProps } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: 'NO TITLE PROVIDED'
    }
});

</script>