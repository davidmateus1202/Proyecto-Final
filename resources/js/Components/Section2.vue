<template>
    <div class="flex flex-col top-0 left-0 w-full min-h-screen h-auto bg-white items-center justify-start p-10">
        <h1 class="text-4xl font-semibold text-center">Detecta, clasifica y actúa: el futuro del mantenimiento vial.</h1>
        <span class="text-center mt-2">Sistema multiplataforma para inspección y diagnóstico de pavimentos rígidos.</span>
        <div ref="cardsContainer" 
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-16 mt-10">
            <Card 
                v-for="(item, index) in imageIcons" 
                :key="index" :icon="item.url" 
                :fondo="item.urlBackground" 
                :title="item.title" 
                :description="item.description" 
                class="card-rotate-item"/>
        </div>

        <div class="flex flex-col lg:flex-row items-center justify-start w-full gap-10 px-5 md:px-20 lg:px-36 xl:px-48 mt-10">
            <img :src="icon10" class="xl:w-[30%] object-cover translate-y-2 hover:translate-y-0 transition-transform duration-300 ease-in-out group-hover:rotate-3 hover:scale-95">
            <div class="flex flex-col flex-1 items-start justify-center lg:justify-start ">
                <h1 class="font-semibold text-4xl">Innovación tecnológica para la inspección y diagnóstico de pavimentos viales!</h1>
                <p class="mt-10 text-left font-light">Este proyecto de grado presenta una solución tecnológica multiplataforma diseñada para optimizar el proceso de inspección de pavimentos rígidos en tramos viales. A través de una aplicación móvil, los inspectores pueden registrar en campo todas las patologías observadas —como fisuras, desprendimientos o fallas estructurales— de manera rápida, ordenada y georreferenciada. Esta información se sincroniza automáticamente con una plataforma web, lo que garantiza una recopilación de datos precisa, eficiente y accesible para su posterior análisis.</p>
                <p class="mt-10 text-left font-light">Una vez consolidada la información, el sistema permite que un ingeniero civil acceda a todos los registros desde un entorno centralizado, donde puede realizar un diagnóstico técnico del estado del tramo vial. Gracias a las herramientas de visualización y generación de reportes, se facilita la toma de decisiones sobre mantenimiento, rehabilitación o intervención. En conjunto, este sistema contribuye a modernizar la gestión de infraestructura vial, apoyando procesos técnicos con tecnología accesible y adaptable al contexto colombiano.</p>
            </div>
        </div>
    </div>

</template>

<script setup>
import Card from './Card.vue';
import icon10 from '../assets/phone.png'
import '../CSS/Section2.css';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { gsap } from 'gsap';
import icon1 from '../assets/icon1.png';
import icon2 from '../assets/icon2.png';
import icon3 from '../assets/icon3.png';
import icon4 from '../assets/icon4.png';

import fondo1 from '../assets/fondo1.png';
import fondo2 from '../assets/fondo2.png';
import fondo3 from '../assets/fondo3.png';
import fondo4 from '../assets/fondo4.png';

const cardsContainer = ref(null);
let observer = null;
let animationDone = false;
const imageIcons = [
    {
        url: icon1,
        urlBackground: fondo1,
        alt: 'Icon 1',
        title: 'Inspección vial más eficiente desde el terreno',
        description: 'Con nuestra aplicación móvil multiplataforma, los inspectores pueden registrar en tiempo real las patologías de pavimentos rígidos.'
    },
    {
        url: icon2,
        urlBackground: fondo2,
        alt: 'Icon 2',
        title: 'Centralización y trazabilidad de datos técnicos',
        description: 'Toda la información recolectada se almacena en una plataforma centralizada, donde se puede consultar, editar y auditar fácilmente.'
    },
    {
        url: icon3,
        urlBackground: fondo3,
        alt: 'Icon 3',
        title: 'Diagnóstico técnico apoyado en tecnología',
        description: 'El sistema permite al ingeniero civil realizar un análisis técnico completo del estado de los pavimentos rígidos, con base en los datos recolectados.'
    },
    {
        url: icon4,
        urlBackground: fondo4,
        alt: 'Icon 4',
        title: 'Transformando la gestión vial con tecnología',
        description: 'Este proyecto busca modernizar el proceso de inspección y diagnóstico de infraestructura vial en Colombia mediante el uso de tecnologías móviles y web.'
    }
]

onMounted(() => {
    if (!cardsContainer.value) return;

    const cardElements = Array.from(cardsContainer.value.querySelectorAll('.card-rotate-item'));

    if (cardElements.length === 0) return;

    // logica para abtener las posiciones de los elementos
    const mindPoint = Math.ceil(cardElements.length / 2);
    const leftCards = cardElements.slice(0, mindPoint);
    const rightCards = cardElements.slice(mindPoint);

    if (leftCards.length > 0) {
        gsap.set(leftCards, {
            rotateY: 90,
            opacity: 0,
            transformOrigin: 'left center',
        });
    }

    if (rightCards.length > 0) {
        gsap.set(rightCards, {
            rotateY: -90,
            opacity: 0,
            transformOrigin: 'right center',
        });
    }

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1, // tiempo para que el elemento sea visible
    };

    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !animationDone) {
                animationDone = true;

                if (leftCards.length > 0) {
                    gsap.to(leftCards, {
                        rotateY: 0,
                        opacity: 1,
                        duration: 1,
                        stagger: 0.2,
                    });
                }

                if (rightCards.length > 0) {
                    gsap.to(rightCards, {
                        rotateY: 0,
                        opacity: 1,
                        duration: 2,
                        stagger: 0.2,
                    });
                }

                if (cardsContainer.value) {
                    observer.unobserve(cardsContainer.value);
                }
            }
        });
    }, options);

    observer.observe(cardsContainer.value);
})


onBeforeUnmount(() => {
    if (observer && cardsContainer.value) {
        observer.unobserve(cardsContainer.value);
    }
    observer = null;
})

</script>