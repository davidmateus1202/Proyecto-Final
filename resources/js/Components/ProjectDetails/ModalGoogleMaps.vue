<template>
    <div class="fixed inset-0 bg-black bg-opacity-30 z-40" @click="closeDropdown">
        <div class="flex items-center justify-center h-full w-full">
            <div class="flex w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-white rounded-3xl shadow-lg p-4">
                <div ref="mapDiv" class="w-full h-full rounded-3xl"></div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { Loader } from '@googlemaps/js-api-loader';
import { ref, onMounted } from 'vue';
import { useProjectStore } from '../../store/projectStore';


const GOOGLE_MAPS_API_KEY = 'AIzaSyDAsoZsSxTGeQwZ37GgsLqx2LfaPCWh0Qs';
const projectStore = useProjectStore();
const map = ref(null);
const mapDiv = ref(null);
const marker = ref(null);
const latitude = ref(null);
const longitude = ref(null);

const emit = defineEmits(['close']);

const initMap = async () => {  
    const loader = new Loader({ apiKey: GOOGLE_MAPS_API_KEY })
    await loader.load();

    const position = { lat: latitude.value, lng: longitude.value };
    map.value = new google.maps.Map(mapDiv.value, {
        center: position,
        zoom: 18,
    });

    marker.value = new google.maps.Marker({
        position: position,
        map: map.value,
        title: 'Hello San Francisco!',
    });
}

const closeDropdown = () => {
    emit('close');
}

onMounted(() => {
    console.log(projectStore.slabSelected);
    latitude.value = parseFloat(projectStore.slabSelected.latitude);
    longitude.value = parseFloat(projectStore.slabSelected.longitude);
    initMap();
});

</script>