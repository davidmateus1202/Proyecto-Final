<template>
    <nav :class="[
        'fixed w-full z-30 top-0 start-0 transition-all duration-300 ease-in-out',
        isScrolled ? 'bg-white shadow-md' : 'bg-transparent', // Añadido shadow-md para mejor visibilidad
    ]">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo -->
            <a href="#" @click.prevent="navigateTo('Home')" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img :src="logo" class="h-12 mr-5" alt="Flowbite Logo"> <!-- Ajustado tamaño de logo y h-18 a h-16 o similar -->
            </a>

            <!-- Botón Hamburguesa para Móvil -->
            <div class="flex md:order-2 items-center">
                <button @click="toggleMobileMenu" data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2"
                    :class="isScrolled || isMobileMenuOpen ? 'text-gray-700 hover:bg-gray-100 focus:ring-gray-200' : 'text-gray-200 hover:bg-white/20 focus:ring-gray-600'"
                    aria-controls="navbar-sticky" :aria-expanded="isMobileMenuOpen.toString()">
                    <span class="sr-only">Open main menu</span>
                    <svg v-if="!isMobileMenuOpen" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                    <svg v-else class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menú Desktop -->
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                    <li v-for="link in navLinks" :key="link.name">
                        <button @click="handleNavLinkClick(link.name)" :class="[
                            'block py-2 px-3 rounded-sm md:bg-transparent md:p-0 cursor-pointer transition-colors duration-200',
                            isScrolled ? 'text-black hover:text-teal-600 md:hover:bg-transparent' : 'text-white hover:text-gray-300 md:hover:bg-transparent'
                        ]">
                            {{ link.label }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Drawer Menú Móvil -->
        <!-- Overlay para cerrar el menú al hacer clic fuera -->
        <div v-if="isMobileMenuOpen" @click="toggleMobileMenu" class="fixed inset-0 bg-black/30 z-30 md:hidden"></div>

        <div :class="[
            'fixed top-0 left-0 h-full w-64 sm:w-80 bg-white shadow-xl z-40 transform transition-transform duration-300 ease-in-out md:hidden',
            isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
            <div class="flex flex-col w-full h-full justify-between p-5">
                <!-- Cabecera del Drawer (Opcional, con logo y botón de cerrar) -->
                <div class="flex justify-between items-center mb-6">
                    <img :src="logo" class="h-14 mr-5" alt="Flowbite Logo">
                    <button @click="toggleMobileMenu" class="p-2 text-gray-600 hover:text-gray-800">
                        <span class="sr-only">Close menu</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Enlaces del Menú Móvil -->
                <ul class="space-y-2">
                    <li v-for="link in navLinks" :key="`mobile-${link.name}`">
                        <button @click="handleNavLinkClick(link.name)"
                            class="w-full text-left block py-2 px-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-teal-600 transition-colors duration-200 font-medium">
                            {{ link.label }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue';
import logo from '../assets/icon11.png' // Asegúrate que la ruta es correcta
import { useRouter } from 'vue-router';

const router = useRouter();
const point_scroll = 100; // Reducido para prueba, ajusta según necesites
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const navLinks = ref([
    { name: 'Welcome', label: 'Inicio' },
    { name: 'About', label: 'Nosotros' },
    { name: 'Project', label: 'Proyectos' },
]);

const handleScroll = () => {
    if (window.scrollY > point_scroll) {
        isScrolled.value = true;
    } else {
        isScrolled.value = false;
    }
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Check scroll position on mount
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    // Asegurarse de limpiar el overflow del body si el componente se destruye con el menú abierto
    if (document.body.style.overflow === 'hidden') {
        document.body.style.overflow = '';
    }
});

const navigateTo = (name) => {
    router.push({ name });
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const handleNavLinkClick = (routeName) => {
    navigateTo(routeName);
    if (isMobileMenuOpen.value) {
        isMobileMenuOpen.value = false; // Cierra el menú móvil después de la navegación
    }
};

// Observador para bloquear/desbloquear el scroll del body
watch(isMobileMenuOpen, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

const openWindow = (url) => {
    window.open(url, '_blank');
};

</script>