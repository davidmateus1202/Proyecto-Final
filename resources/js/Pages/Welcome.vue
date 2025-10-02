<template>

    <div v-if="allComponentsReady && !showLoadingScreen" class="flex flex-col top-0 left-0 w-full h-full bg-white overflow-x-hidden">
        <NavBar />
        <Carrusel />
        <Section2 />
        <Section3 />
        <Section4 />
        <Section5 />
        <Footer />
    </div>

    <!-- El componente de carga. -->
    <Loading v-if="showLoadingScreen" :is-actually-loading="!allComponentsReady" />
</template>

<script setup>
import NavBar from '../Components/NavBar.vue'
import Carrusel from '../Components/Carrusel.vue'
import Section2 from '../Components/Section2.vue'
import Section3 from '../Components/Section3.vue'
import Section4 from '../Components/Section4.vue'
import Section5 from '../Components/Section5.vue'
import Footer from '../Components/Footer.vue'
import Loading from './Loading.vue'
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