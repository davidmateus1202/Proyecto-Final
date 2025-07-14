<template>
    <div class="flex flex-col top-0 left-0 w-full h-full items-center justify-center cursor-pointer"
        @click="emitImageClick">
        <div class="flex group w-72 h-72 bg-[#349896] rounded-full transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg hover:shadow-[#4eb3af]">
            <img :src="props.imageUrl" alt="Imagen de reseña"
                class="w-full h-full object-cover rounded-full translate-y-2 hover:translate-y-0 transition-transform duration-300 ease-in-out group-hover:rotate-3 hover:scale-95">
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    imageUrl: {
        type: String,
        required: true,
        default: 'https://media.istockphoto.com/id/958731110/es/foto/ellanatural.jpg?s=612x612&w=0&k=20&c=dkC7XUeOCLbKk83MfxyetDHZLeF3efjs9drbzjXxQoc='
    }
});

const emit = defineEmits(['image-selected']);
const emitImageClick = () => {
    emit('image-selected', props.imageUrl);
};

</script>