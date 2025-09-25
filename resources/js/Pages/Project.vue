<template>
    <div class="flex flex-col items-center justify-center w-full h-auto min-h-screen overflow-x-hidden">
        <NavBar />
        <Header title="Proyectos"/>
        <Section5 />
        <Footer class="w-full" />
    </div>

    <Loading v-if="showLoadingScreen" :is-actually-loading="!allComponentsReady" />
</template>

<script setup>
import NavBar from '../Components/NavBar.vue';
import Header from '../Components/Header.vue';
import Section5 from '../Components/Section5.vue';
import Footer from '../Components/Footer.vue';
import Loading from './Loading.vue';
import { ref, onMounted } from 'vue'

const FADE_OUT_DURATION_LOADING_ELEMENTS = 0.2;
const EXPANSION_DURATION_LOADING = 0.7;

onMounted(async () => {
    showLoadingScreen.value = true;
    allComponentsReady.value = false;
    console.log("HomePage: Montado, iniciando carga simulada...");
    await new Promise(resolve => setTimeout(resolve, 3500));

    console.log("HomePage: Carga de componentes/datos terminada.");
    allComponentsReady.value = true; 

    const totalLoadingTransitionTime = FADE_OUT_DURATION_LOADING_ELEMENTS + EXPANSION_DURATION_LOADING;

    setTimeout(() => {
        console.log("HomePage: Ocultando pantalla de carga.");
        showLoadingScreen.value = false; // Desmonta Loading.vue y muestra el contenido
    }, (totalLoadingTransitionTime * 1000) + 100); // Multiplicar por 1000 para ms y añadir un pequeño buffer (100ms)
});

</script>