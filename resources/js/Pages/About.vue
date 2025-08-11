<template>
    <div class="flex flex-col items-center justify-center w-full h-auto min-h-screen overflow-hidden">
        <NavBar />
        <Header title="Sobre Nosotros" />
        <Section2 />
        <Footer class="w-full" />
    </div>
</template>

<script setup>
import NavBar from '../Components/NavBar.vue';
import Header from '../Components/Header.vue';
import Section2 from '../Components/Section2.vue';
import Footer from '../Components/Footer.vue';
</script>