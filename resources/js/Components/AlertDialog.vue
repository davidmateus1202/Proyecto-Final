<template>
    <div class="fixed inset-0 w-full h-full bg-black/50 z-50 flex items-center justify-center">
        <div class="flex flex-col bg-white rounded-2xl shadow-2xl w-11/12 md:w-96 p-5">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold">{{ props.title }}</h1>
                <button 
                    @click="closeDialog"
                    class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200">
                    <IconX stroke={2} />
                </button>
            </div>

            <div class="flex mt-5 justify-center items-center gap-x-3 text-gray-700">
                <IconAlertTriangle stroke={2} />
                <h1 class="font-medium">{{ props.message }}</h1>
            </div>

            <div class="flex mt-5 justify-end items-center gap-x-3">
                <button 
                    v-if="props.show" 
                    @click="props.onCancel"
                    class="px-4 py-2 rounded-2xl border border-gray-300 hover:bg-gray-100">
                    {{ props.buttonCancelText }}
                </button>
                <button 
                    @click="props.onConfirm"
                    class="px-4 py-2 rounded-2xl bg-black text-white hover:bg-gray-800">
                    {{ props.buttonConfirmText }}
                </button>

            </div>
        </div>
    </div>
</template>

<script setup>
import { IconX, IconAlertTriangle } from '@tabler/icons-vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Confirmación'
    },
    message: {
        type: String,
        default: '¿Estás seguro que deseas continuar?'
    },
    buttonConfirmText: {
        type: String,
        default: 'Continuar'
    },
    onConfirm: {
        type: Function,
        default: () => {}
    },
    buttonCancelText: {
        type: String,
        default: 'Cancelar'
    },
    onCancel: {
        type: Function,
        default: () => {}
    },
    show: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['close']);

const closeDialog = () => {
    emit('close');
}

</script>