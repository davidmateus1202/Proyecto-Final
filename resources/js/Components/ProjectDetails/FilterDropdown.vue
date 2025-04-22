<template>

    <div class="fixed inset-0 bg-black bg-opacity-30 z-40" @click="closeDropdown"></div>
    <div class="absolute bg-white shadow-lg rounded-3xl p-4 z-50 w-64"
        :style="{ top: `${position.top}px`, left: `${position.left}px` }">

        <div v-for="(project, index) in projectStore.abscisaSelected.slabs_with_pathologies" class="flex flex-col w-full h-auto items-start justify-start gap-y-3">
            <div @click="filterButton(project.id)" :key="index" class="flex w-full h-auto items-center justify-between cursor-pointer hover:bg-gray-100 p-2 rounded-lg">
                <h1 :key="index">Placa - {{ project.id }}</h1>
                <div class="flex bg-gray-200 w-8 h-8 rounded-full items-center justify-center shadow-sm">
                    <i class="pi pi-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { defineProps } from 'vue';
import { useProjectStore } from '../../store/projectStore';

const projectStore = useProjectStore()
const props = defineProps({
    position: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close']);

const closeDropdown = () => {
    emit('close');
}

const filterButton = (id) => {
    projectStore.setPlacaSelectedId(id);
    emit('close');
}

</script>