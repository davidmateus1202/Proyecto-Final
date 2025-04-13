<template>
    <div class="flex flex-col w-full h-auto items-start justify-start gap-y-5">
        <h1 class="text-gray-600 font-bold text-sm md:text-lg lg:text-xl">Información adicional sobre la abscisa</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full h-auto">
            <!-- grafic 1 -->
            <div class="flex-1 flex bg-gray-50 rounded-3xl p-5 max-h-80">
                <GraficView />
            </div>
            <div class="flex-1 flex flex-col p-5 items-center justify-center max-h-80">
                <PieGraficView />
                <h1 class="font-bold text-gray-600 mt-4">Relación del área afectada</h1>
                <span class="text-xs lg:max-w-80 text-center text-gray-400">Análisis proporcional del área afectada en relación con la superficie conservada en estado saludable.</span>
            </div>
        </div>
    </div>
</template>

<script setup>

import GraficView from './GraficView.vue';
import PieGraficView from './PieGraficView.vue';

</script>