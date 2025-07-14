// ImageModal.vue
<template>
    <Transition name="modal-fade">
        <div 
            v-if="show" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            @click.self="closeModal" 
        >
            <div class="relative rounded-lg shadow-xl max-w-4xl max-h-[90vh] w-auto">
                <button 
                    @click="closeModal"
                    class="absolute -top-3 -right-3 bg-white rounded-full p-1 text-gray-700 hover:text-black focus:outline-none z-10"
                    aria-label="Cerrar modal"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img 
                    :src="imageUrl" 
                    alt="Imagen ampliada" 
                    class="object-contain max-w-full max-h-[85vh] rounded"
                >
            </div>
        </div>
    </Transition>
</template>

<script setup>
const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  imageUrl: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['close']);

const closeModal = () => {
  emit('close');
};

// Opcional: Cerrar con la tecla Escape
import { onMounted, onUnmounted } from 'vue';
const handleKeydown = (event) => {
  if (event.key === 'Escape' && props.show) {
    closeModal();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
});
</script>

<style scoped>
/* Transición para el modal */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

/* Estilos para el botón de cerrar, puedes personalizarlos más */
.absolute.-top-3.-right-3 {
    top: -0.75rem;
    right: -0.75rem;
}
</style>