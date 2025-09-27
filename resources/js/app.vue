<template>
    <main class="flex w-full h-full">
        <Sidebar v-if="auth.authUser === true" @logout="handleLogout" />
        <router-view />
        <!-- Alert Dialog -->
        <AlertDialog v-if="showAlert" @close="closeAlert" :show="true" :onCancel="closeAlert" :onConfirm="logout"/>
    </main>
</template>

<script setup>
import Sidebar from './Components/Sidebar.vue';
import { useAuthStore } from './store/authStore';
import AlertDialog from './Components/AlertDialog.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const showAlert = ref(false);
const auth = useAuthStore();
const route = useRouter();

const handleLogout = () => {
    showAlert.value = true;
}

const closeAlert = () => {
    showAlert.value = false;
}

const logout = async () => {
    await auth.logout();
    route.push({ name: 'Login' });
    showAlert.value = false;
}

</script>
