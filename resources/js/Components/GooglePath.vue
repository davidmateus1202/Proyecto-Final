<template>
    <div ref="mapDiv" class="w-full h-[300px] rounded-3xl"></div>
</template>

<script setup>

import { Loader } from '@googlemaps/js-api-loader';
import { ref, onMounted } from 'vue';


const GOOGLE_MAPS_API_KEY = 'AIzaSyDwDGo35eOfpvz8g6zn8AGV2Sli49YowqY';
const map = ref(null);
const mapDiv = ref(null);
const marker = ref(null);

const directionsService = ref(null);
const directionsRenderer = ref(null);

const props = defineProps({
    initialLatitude: {
        required: true,
    },
    initialLongitude: {
        required: true,
    },
    destinationLatitude: {
        required: true,
    },
    destinationLongitude: {
        required: true,
    }

})


const initMap = async () => {  
    const loader = new Loader({ apiKey: GOOGLE_MAPS_API_KEY })
    await loader.load();

    const position = { lat: props.initialLatitude, lng: props.initialLongitude };
    const destination = { lat: props.destinationLatitude, lng: props.destinationLongitude };

    map.value = new google.maps.Map(mapDiv.value, {
        center: position,
        zoom: 14,
    });

    directionsService.value = new google.maps.DirectionsService();
    directionsRenderer.value = new google.maps.DirectionsRenderer();
    directionsRenderer.value.setMap(map.value);

    displayRoute(position, destination);
}

const displayRoute = (origin, destination) => {
    if (!directionsService.value || !directionsRenderer.value) {
        console.error("Directions services not initialized.");
        return;
    }

    directionsService.value.route(
        {
            origin: origin,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING, // Puedes cambiar a WALKING, BICYCLING, TRANSIT
        },
        (response, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.value.setDirections(response);
                // Opcional: Si el DirectionsRenderer dibuja los marcadores de inicio/fin,
                // el marcador original puede ser redundante.
                if (marker.value) {
                    marker.value.setMap(null); // Elimina el marcador original
                }
            } else {
                window.alert('La solicitud de ruta falló debido a: ' + status);
            }
        }
    );
};

onMounted(() => {
    initMap();
});

</script>