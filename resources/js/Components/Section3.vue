<template>
    <div class="relative w-screen min-h-[500px] h-auto">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img :src="fondo4" class="object-cover w-full h-full" alt="Background Image" />
        </div>
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>

        <div class="relative z-10 flex flex-col items-center justify-center h-full p-16">
            <h1 class="font-semibold text-3xl text-white text-center">La Experiencia Selva Bowling: Diversión, Sabor e Innovación en un Solo Lugar</h1>
            <h3 class="text-white font-light my-5">Nuestra dedicación a ir más allá de lo ordinario.</h3>
            <div ref="cardsContainer" class="grid grid-cols-1 lg:grid-cols-4 w-full h-full gap-x-5 px-5">
                <CardDetails
                    v-for="(item, index) in carditems"
                    :key="index"
                    :title="item.title"
                    :description="item.description"
                    class="card-item-gsap"
                    />  
            </div>
        </div>

    </div>
</template>

<script setup>
import fondo4 from '../assets/fondo4.webp';
import CardDetails from './CardDetails.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { gsap } from 'gsap';


const carditems = ref([
    {
        title: 'Registro de patologías en tiempo real',
        description: 'La app permite documentar fallas y daños en el pavimento rígido directamente desde el sitio de inspección. Cada registro incluye fotos, ubicación GPS, tipo de patología y observaciones técnicas, lo que agiliza la toma de datos y garantiza su exactitud desde el terreno.',
    },
    {
        title: 'Georreferenciación automática de tramos',
        description: 'Cada tramo y cada patología se georreferencia automáticamente utilizando los sensores del dispositivo móvil. Esto permite visualizar los daños sobre un mapa, facilitando la planificación de intervenciones y el seguimiento del estado de la vía en futuras visitas.',
    },
    {
        title: 'Sincronización con la plataforma web',
        description: 'Toda la información capturada desde la app se sincroniza de forma segura con una plataforma web centralizada. Esto permite al equipo técnico acceder, revisar y gestionar los datos en tiempo real desde cualquier lugar, asegurando continuidad en el proceso diagnóstico.',
    },
    {
        title: 'Historial y trazabilidad de inspecciones',
        description: 'La app permite consultar inspecciones anteriores por tramo, fecha o tipo de patología. Este historial técnico facilita la trazabilidad de los daños, la evaluación del deterioro progresivo y el respaldo documental ante entidades encargadas de la gestión vial.',
    },
]);

const cardsContainer = ref(null);
let observer = null;
let animationDone = false;

onMounted(() => {
    if (!cardsContainer.value) return;

    gsap.set(".card-item-gsap", {
        opacity: 0,
        x: 0,
        y: -50
    });

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // animar cuando el 20% del elemento sea visible
    }

    observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0 && !animationDone) {
                gsap.to(".card-item-gsap", {
                    opacity: 1,
                    x: 0,
                    y: 0,
                    duration: 1,
                    stagger: 0.2,
                    ease: "power3.out",
                    delay: 0.2,
                });
                observer.unobserve(cardsContainer.value);
            }
        })
    }, options)

    observer.observe(cardsContainer.value);
})

onBeforeUnmount(() => {
    if (observer && cardsContainer.value) {
        observer.unobserve(cardsContainer.value);
    }
    observer = null;
})

</script>