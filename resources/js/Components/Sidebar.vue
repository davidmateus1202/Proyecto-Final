<template>
    <div 
        class="flex flex-row md:flex-col w-full md:w-[80px] min-w-[80px] h-10 md:max-h-screen md:min-h-screen  fixed bottom-0 items-center justify-between py-5 md:relative bg-white">
        <div class="hidden md:block">
            <img :src="icon1" class="w-14">
        </div>

        <!-- icons -->
        <div class="flex md:flex-col w-full md:w-auto items-center justify-center mt-0 md:mt-10 gap-y-8 gap-x-5">
            <button class="hover:bg-primary rounded-3xl p-2">
                <img :src="icon2" class="w-8">
            </button>

            <button class="hover:bg-primary rounded-3xl p-2">
                <img :src="icon3" class="w-8">
            </button>
        </div>

        <!-- Parte inferior (Ajustes y Perfil) -->
        <div class="hidden md:flex flex-col justify-center items-center gap-3">
            <button @click="logout" class="hover:rounded-3xl group">
                <img :src="logoutIcon" class="w-8">
            </button>
            <img class="rounded-full w-10 h-10 border border-spacing-2"
                src="https://static.vecteezy.com/system/resources/thumbnails/020/765/399/small/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg"
                alt="profile" />
        </div>


    </div>

</template>

<script setup>

import icon1 from '../assets/icon1.png';
import icon2 from '../assets/icon2.png';
import icon3 from '../assets/icon3.png';
import logoutIcon from '../assets/logout.png';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../store/authStore';

const route = useRouter();
const auth = useAuthStore();


const logout = () => {
    auth.authUser = false;
    localStorage.removeItem('token');
    route.push({ name: 'Login' });
}

</script>