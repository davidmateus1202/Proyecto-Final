<template>
    <div class="flex flex-col top-0 left-0 w-full h-auto bg-white items-center justify-start p-10">
        <h1 class="text-4xl font-semibold text-center">Bowlix: Where Fun ans Flavor Collide</h1>
        <span class="text-center mt-2">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</span>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-16 mt-10 gap-y-16">
            <Card />
            <Card />
            <Card />
            <Card />
        </div>
    </div>
</template>

<script setup>

import Card from './Card.vue'

</script>