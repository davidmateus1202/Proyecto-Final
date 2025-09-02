<template>
    <div class="flex flex-col top-0 left-0 w-full min-h-screen h-auto bg-white items-center justify-start p-10">
        <h1 class="text-4xl font-semibold text-center">Proyectos de Investigación en Pavimentos Rígidos</h1>
        <span class="text-center mt-2">Presentamos investigaciones centradas en diagnosticar las causas del deterioro del pavimento para proponer métodos de <br /> evaluación y rehabilitación que garanticen una mayor vida útil.</span>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-16 mt-10 gap-y-16">
            <PhotoCard v-for="(image, index) in images" 
                :key="index" 
                :imageUrl="image.url" 
                @image-selected="openImageModal"
            />
        </div>
    </div>

    <ImageModal 
        :show="showModal"
        :imageUrl="selectedImage"
        @close="closeImageModal"
    />
</template>

<script setup>

import PhotoCard from './PhotoCard.vue'
import { ref } from 'vue';
import ImageModal from './ImageModal.vue';

const showModal = ref(false);
const selectedImage = ref('');
const images = ref([
  { url: 'https://media.istockphoto.com/id/958731110/es/foto/ellanatural.jpg?s=612x612&w=0&k=20&c=dkC7XUeOCLbKk83MfxyetDHZLeF3efjs9drbzjXxQoc=' },
  { url: 'https://images.pexels.com/photos/3225517/pexels-photo-3225517.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/15286/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/2356045/pexels-photo-2356045.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/417074/pexels-photo-417074.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/167699/pexels-photo-167699.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
  { url: 'https://images.pexels.com/photos/2662116/pexels-photo-2662116.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' },
]);

const openImageModal = (imageUrl) => {
    selectedImage.value = imageUrl;
    showModal.value = true;
    document.body.style.overflow = 'hidden'; // Deshabilitar el scroll del body
}

const closeImageModal = () => {
    showModal.value = false;
    selectedImage.value = '';
    document.body.style.overflow = ''; // Rehabilitar el scroll del body
}

</script>