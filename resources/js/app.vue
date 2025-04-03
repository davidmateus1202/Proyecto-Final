<template>
    <main class="flex w-full h-full">
        <Sidebar v-if="auth.authUser === true"  />
            <router-view />
    </main>
</template>

<script setup>
import Sidebar from './Components/Sidebar.vue';
import { useAuthStore } from './store/authStore';

const auth = useAuthStore();

</script>
