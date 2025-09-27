<template>
  <footer class="bg-gray-50">
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
      <div class="sm:flex sm:items-center sm:justify-between">
        <div class="flex justify-center text-teal-600 sm:justify-start">
          <img :src="Logo" alt="Logo" class="h-12 w-12"/>
        </div>
  
        <p class="mt-4 text-center text-sm text-gray-500 lg:mt-0 lg:text-right">
          Copyright &copy; 2022. All rights reserved.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import Logo from '../assets/icon11.png';
</script>