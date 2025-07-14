<template>
    <nav :class="[
        'fixed w-full z-30 top-0 start-0 transition-all duration-300 ease-in-out',
        isScrolled ? 'bg-white' : 'bg-transparent',
    ]">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <img :src="logo" class="h-10" alt="Flowbite Logo">
                
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                    <li>
                        <button @click="navigateTo('Home')" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer',
                            isScrolled ? 'text-black hover:bg-gray-100 md:hover:bg-transparent' : 'text-white hover:bg-gray-100 md:hover:bg-transparent'
                        ]">Inicio</button>
                    </li>
                    <li>
                        <button @click="navigateTo('About')" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer',
                            isScrolled ? 'text-black hover:bg-gray-100 md:hover:bg-transparent' : 'text-white hover:bg-gray-100 md:hover:bg-transparent'
                        ]">Nosotros</button>     
                    </li>
                    <li>
                        <button @click="navigateTo('Services')" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer',
                            isScrolled ? 'text-black hover:bg-gray-100 md:hover:bg-transparent' : 'text-white hover:bg-gray-100 md:hover:bg-transparent'
                        ]">Servicios</button>
                    </li>
                    <li>
                        <button @click="navigateTo('Gallery')" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer',
                            isScrolled ? 'text-black hover:bg-gray-100 md:hover:bg-transparent' : 'text-white hover:bg-gray-100 md:hover:bg-transparent'
                        ]">Galeria</button>
                    </li>
                    <li>
                        <button @click="navigateTo('Contact')" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer',
                            isScrolled ? 'text-black hover:bg-gray-100 md:hover:bg-transparent' : 'text-white hover:bg-gray-100 md:hover:bg-transparent'
                        ]">Contacto</button>
                    </li>
                </ul>
            </div>

            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                <button data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import logo from '../assets/icon11.png';

const router = useRouter();
const point_scroll = 400;
const isScrolled = ref(false);

const handleScroll = () => {
    if (window.scrollY > point_scroll) {
        isScrolled.value = true;
    } else {
        isScrolled.value = false;
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Check scroll position on mount
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const navigateTo = (name) => {
  try {
    router.push({ name });
  } catch (e) {
    console.error('Navigation error:', e);
  }
};


</script>