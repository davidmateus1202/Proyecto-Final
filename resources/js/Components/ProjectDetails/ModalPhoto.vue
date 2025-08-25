<template>
    <div class="fixed inset-0 bg-black bg-opacity-30 z-40" @click="closeDropdown">
        <div class="flex items-center justify-center h-full w-full">
            <div class="flex w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-white rounded-3xl shadow-lg p-4">
                <img :src="props.imageUrl" class="w-full h-full object-cover rounded-3xl">
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    imageUrl: String
})
const emit = defineEmits(['close']);

const closeDropdown = () => {
    emit('close');
}

</script>