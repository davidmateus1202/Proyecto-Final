<template>
    <div class="flex flex-col w-full h-full overflow-x-hidden">
        <div class="w-full min-h-screen h-auto  relative" :style="{
             backgroundImage: `url(${fondo})`, 
             backgroundSize: 'cover', 
             }">
             <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <NavBar class="absolute top-0 left-0 w-full z-50"/>
            <div class="flex flex-col w-full lg:w-[60%] xl:w-[80%] h-full min-h-screen items-start justify-center px-5 md:px-20 lg:px-32 xl:px-40">
                <h1 class="text-[30px] lg:text-[40px] xl:text-[60px] text-primary z-10 font-black">Crea con tu mente</h1>
                <h1 class="font-black text-white z-10 text-[40px] lg:text-[60px] xl:text-[80px]">Centro de Patologico</h1>
                <span class="font-extralight text-gray-200 z-10 mb-8 text-xs md:text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, distinctio eligendi! Cum eaque dolores explicabo alias deleniti.</span>
                <Button />
            </div>      
        </div>

        <section class="flex flex-col w-full min-h-screen h-auto items-center justify-center bg-gray-50 py-20">

                <!-- card information -->
                <div class="flex flex-col md:flex-row w-full lg:max-w-[60%] h-auto gap-3 md:gap-10 items-center px-10">
                    <h1 class="text-center md:text-right font-extrabold md:text-xl lg:text-3xl xl:text-4xl">Lorem ipsum dolor sit amet consectetur</h1>
                    <div class="w-full md:w-3 h-1 md:h-32 bg-primary rounded-3xl"></div>
                    <span class="font-extralight text-xs text-gray-400">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quod inventore odit provident quae voluptate rem aspernatur reprehenderit quisquam sit Lorem ipsum dolor sit amet consectetur adipisicing.</span>
                </div> 

                <!-- card information -->
                 <div class="flex w-full h-auto items-center justify-center mt-16 px-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 w-full  md:max-w-[80%] h-auto">
                        <section class="flex flex-col items-center justify-center bg-white rounded-3xl p-5 gap-y-3">
                            <img :src="icon6" class="w-14">
                            <h1 class="font-extrabold text-lg">Lorem ipsum dolor</h1>
                            <span class="text-xs text-gray-400 text-center mx-10">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quod inventore odit provident quae voluptate rem aspernatur reprehenderit quisquam sit Lorem ipsum dolor sit amet consectetur adipisicing.
                            </span>
                        </section>

                        <section class="flex flex-col items-center justify-center bg-white rounded-3xl p-5 gap-y-3">
                            <img :src="icon6" class="w-14">
                            <h1 class="font-extrabold text-lg">Lorem ipsum dolor</h1>
                            <span class="text-xs text-gray-400 text-center mx-10">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quod inventore odit provident quae voluptate rem aspernatur reprehenderit quisquam sit Lorem ipsum dolor sit amet consectetur adipisicing.
                            </span>

                        </section>

                        <section class="flex flex-col items-center justify-center bg-white rounded-3xl p-5 gap-y-3">
                            <img :src="icon6" class="w-14">
                            <h1 class="font-extrabold text-lg">Lorem ipsum dolor</h1>
                            <span class="text-xs text-gray-400 text-center mx-10">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quod inventore odit provident quae voluptate rem aspernatur reprehenderit quisquam sit Lorem ipsum dolor sit amet consectetur adipisicing.
                            </span>

                        </section>

                        <section class="flex flex-col items-center justify-center bg-white rounded-3xl p-5 gap-y-3">
                            <img :src="icon6" class="w-14">
                            <h1 class="font-extrabold text-lg">Lorem ipsum dolor</h1>
                            <span class="text-xs text-gray-400 text-center mx-10">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quod inventore odit provident quae voluptate rem aspernatur reprehenderit quisquam sit Lorem ipsum dolor sit amet consectetur adipisicing.
                            </span>
                        </section>
                    </div>
                 </div>  
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 w-full h-auto">

            <div 
                class="w-full h-[300px] lg:h-[500px] relative transition-transform duration-500 transform hover:scale-95 cursor-pointer"
                :style="{
                    backgroundImage: `url(https://pbs.twimg.com/media/EiikNZUXcAIyvfC.jpg)`, 
                    backgroundSize: 'cover', 
                }"
                >
                <div class="absolute inset-0 bg-primary bg-opacity-20"></div>
                <div class="flex flex-col w-full h-full justify-end p-5">
                    <span class="text-black text-lg z-10 font-extralight">Proyecto de inspeccion vial</span>
                    <h1 class="text-black z-10 font-extrabold text-3xl">Estado Via Catama</h1>
                    <span class="text-xs text-black z-10">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis quibusdam aliquam error itaque alias ad excepturi et inventore provident magnam perspiciatis.</span>
                </div>
            </div>

            <div 
                class="w-full h-[300px] lg:h-[500px] relative transition-transform duration-500 transform hover:scale-95 cursor-pointer"
                :style="{
                    backgroundImage: `url(https://www.rcnradio.com/_next/image?url=https%3A%2F%2Ffiles.rcnradio.com%2Fpublic%2Fstyles%2F16_9%2Fpublic%2F2024-11%2Fvia_al_llano.jpg%3FVersionId%3DCLmjI.vZdD09dCDirhO8w6jFSHINx3wa%26h%3Defb641cb%26itok%3DzmA25biX&w=3840&q=75)`, 
                    backgroundSize: 'cover', 
                }"
                >
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="flex flex-col w-full h-full justify-end p-5">
                    <span class="text-white text-lg z-10 font-extralight">Proyecto de inspeccion vial</span>
                    <h1 class="text-white z-10 font-extrabold text-3xl">Estado Via Catama</h1>
                    <span class="text-xs text-white z-10">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis quibusdam aliquam error itaque alias ad excepturi et inventore provident magnam perspiciatis.</span>
                </div>
            </div>

            <div 
                class="w-full h-[300px] lg:h-[500px] relative transition-transform duration-500 transform hover:scale-95 cursor-pointer"
                :style="{
                    backgroundImage: `url(https://pbs.twimg.com/media/EiikNZUXcAIyvfC.jpg)`, 
                    backgroundSize: 'cover', 
                }"
                >
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="flex flex-col w-full h-full justify-end p-5">
                    <span class="text-white text-lg z-10 font-extralight">Proyecto de inspeccion vial</span>
                    <h1 class="text-white z-10 font-extrabold text-3xl">Estado Via Catama</h1>
                    <span class="text-xs text-white z-10">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis quibusdam aliquam error itaque alias ad excepturi et inventore provident magnam perspiciatis.</span>
                </div>
            </div>

            <div 
                class="w-full h-[300px] lg:h-[500px] relative transition-transform duration-500 transform hover:scale-95 cursor-pointer"
                :style="{
                    backgroundImage: `url(https://www.rcnradio.com/_next/image?url=https%3A%2F%2Ffiles.rcnradio.com%2Fpublic%2Fstyles%2F16_9%2Fpublic%2F2024-11%2Fvia_al_llano.jpg%3FVersionId%3DCLmjI.vZdD09dCDirhO8w6jFSHINx3wa%26h%3Defb641cb%26itok%3DzmA25biX&w=3840&q=75)`, 
                    backgroundSize: 'cover', 
                }"
                >
                <div class="absolute inset-0 bg-primary bg-opacity-20"></div>
                <div class="flex flex-col w-full h-full justify-end p-5">
                    <span class="text-black text-lg z-10 font-extralight">Proyecto de inspeccion vial</span>
                    <h1 class="text-black z-10 font-extrabold text-3xl">Estado Via Catama</h1>
                    <span class="text-xs text-black z-10">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis quibusdam aliquam error itaque alias ad excepturi et inventore provident magnam perspiciatis.</span>
                </div>
            </div>
        </div>

        <Footer />

    </div>
</template>

<script setup>
import NavBar from '../Components/NavBar.vue';
import Footer from '../Components/Footer.vue';

import fondo from '@/assets/fondo.jpg';
import icon6 from '@/assets/icon6.png';
import Button from '../Components/Button.vue';

</script>