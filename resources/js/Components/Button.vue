<template>
    <button
    @click="go"
      class="bg-white text-center w-48 rounded-2xl h-14 relative text-black text-xl font-semibold group"
      type="button"
    >
      <div
        class="bg-primary rounded-xl h-12 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[184px] z-10 duration-500"
      >
        <i class="pi pi-arrow-right text-white text-sm"></i>
      </div>
      <p class="translate-x-2">Ir ahora</p>
    </button>

</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const go = () => {
  router.push({ name: 'Login' });
};
</script>
  