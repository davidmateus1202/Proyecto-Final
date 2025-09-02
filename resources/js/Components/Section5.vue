<template>
    <div class="flex flex-col top-0 left-0 w-full h-auto bg-white items-center justify-start p-10">
        <h1 class="text-4xl font-semibold text-center">Bowlix: Where Fun ans Flavor Collide</h1>
        <span class="text-center mt-2">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</span>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-16 mt-10 gap-y-16">
            <Card 
                v-for="(item, index) in imageIcons" 
                :key="index" :icon="item.url" 
                :fondo="item.urlBackground" 
                :title="item.title" 
                :description="item.description" 
                class="card-rotate-item"/>
        </div>
    </div>
</template>

<script setup>

import Card from './Card.vue'
import icon1 from '../assets/icon1.png';
import icon2 from '../assets/icon2.png';
import icon3 from '../assets/icon3.png';
import icon4 from '../assets/icon4.png';

import fondo1 from '../assets/fondo1.webp';
import fondo2 from '../assets/fondo2.webp';
import fondo3 from '../assets/fondo3.webp';
import fondo4 from '../assets/fondo4.webp';

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

</script>