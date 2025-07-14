<template>
    <div class="relative h-auto w-screen overflow-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img :src="selvaFondo2" class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>

        <div class="relative z-10 flex flex-col items-center justify-center h-full p-10">
            <div class="flex flex-col lg:flex-row w-full h-auto items-center">
                <img :src="logo" class="hidden md:block h-24 w-72">
                <div class="hidden md:flex w-full h-auto items-center justify-center gap-x-5">
                    <IconPointFilled class="text-white" />
                    <button class="text-white font-medium">Home</button>
                    <button class="text-white font-medium">About Us</button>
                    <button class="text-white font-medium">Services</button>
                    <button class="text-white font-medium">Gallery</button>
                    <button class="text-white font-medium">Blog</button>
                    <button class="text-white font-medium">Contact</button>
                    <IconPointFilled class="text-white" />
                </div>
                <div class="flex items-center justify-center">
                    <IconBrandFacebook stroke={1} class="text-white w-10"/>
                    <IconBrandInstagram stroke={1} class="text-white w-10"/>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full h-full items-center justify-center gap-x-5 gap-y-5 mt-10">
                <ContainerDetails />
                <ContainerDetails />
                <ContainerDetails />
                <ContainerDetails />
            </div>
        </div>
    </div>
</template>

<script setup>
import selvaFondo2 from '../assets/selva-fondo-2.png';
import { IconPointFilled } from '@tabler/icons-vue';
import { IconBrandFacebook } from '@tabler/icons-vue';
import { IconBrandInstagram } from '@tabler/icons-vue';
import logo from '../assets/logo.png'
import ContainerDetails from './ContainerDetails.vue'

</script>