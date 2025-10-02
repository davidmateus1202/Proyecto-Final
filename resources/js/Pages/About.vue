<template>
    <div class="flex flex-col items-center justify-center w-full h-auto min-h-screen overflow-hidden">
        <NavBar />
        <Header title="Sobre Nosotros" />
        <Section2 />
        <Footer class="w-full" />
    </div>
    <Loading v-if="showLoadingScreen" :is-actually-loading="!allComponentsReady" />
</template>

<script setup>
import NavBar from '../Components/NavBar.vue';
import Header from '../Components/Header.vue';
import Section2 from '../Components/Section2.vue';
import Footer from '../Components/Footer.vue';
import Loading from './Loading.vue';
import { ref, onMounted } from 'vue'

const allComponentsReady = ref(false)
const showLoadingScreen = ref(true)

const FADE_OUT_DURATION_LOADING_ELEMENTS = 0.2;
const EXPANSION_DURATION_LOADING = 0.7;

onMounted(async () => {
    showLoadingScreen.value = true;
    allComponentsReady.value = false;
    await new Promise(resolve => setTimeout(resolve, 3500));

    allComponentsReady.value = true;

    const totalLoadingTransitionTime = FADE_OUT_DURATION_LOADING_ELEMENTS + EXPANSION_DURATION_LOADING;

    setTimeout(() => {
        showLoadingScreen.value = false; // Desmonta Loading.vue y muestra el contenido
    }, (totalLoadingTransitionTime * 1000) + 100); // Multiplicar por 1000 para ms y añadir un pequeño buffer (100ms)
});

</script>