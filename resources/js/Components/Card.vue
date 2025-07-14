<template>
    <div class="flex flex-col top-0 left-0 w-full h-full items-center justify-center">
        <div class="flex group w-72 h-72 bg-secondary rounded-full transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg hover:shadow-secondary">
            <img :src="props.fondo" 
                 alt="Background Image"
                class="w-full h-full object-cover rounded-full translate-y-2 hover:translate-y-0 transition-transform duration-300 ease-in-out group-hover:rotate-3 hover:scale-95">
        </div>
        <div class="flex items-center justify-center w-32 h-30 bg-secondary rounded-full z-10 translate-y-[-80px]">
            <div class="flex items-center justify-center w-full h-28 bg-white rounded-full translate-y-2">
                <img :src="props.icon" class="w-16 h-16">
            </div>
        </div>
        <h1 class="text-xl font-bold translate-y-[-60px] text-center">{{ props.title }}</h1>
        <p class="text-center translate-y-[-50px] text-sm font-semibold">{{ props.description }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    fondo: {
        type: String,
        required: true
    },
    title: {
        type: String,
        default: 'Default Title'
    },
    description: {
        type: String,
        default: 'Default Description'
    }
})


</script>