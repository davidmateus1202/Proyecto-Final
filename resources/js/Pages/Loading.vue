<template>
    <div class="fixed inset-0 flex flex-col items-center justify-center bg-white z-50 overflow-hidden">
        <div class="relative flex items-center justify-center">
            <!-- Imagen de carga -->
            <img
                ref="loadingImageRef"
                :src="loadingImage"
                alt="Loading"
                class="w-32 h-32 relative z-10"
            />
            <!-- SVG para el indicador de carga circular -->
            <svg
                ref="progressSvg"
                class="absolute w-40 h-40 transform -rotate-90"
                viewBox="0 0 120 120"
            >
                <circle
                    cx="60"
                    cy="60"
                    r="54"
                    fill="none"
                    stroke="#e6e6e6"
                    stroke-width="8"
                />
                <circle
                    ref="progressCircle"
                    cx="60"
                    cy="60"
                    r="54"
                    fill="none"
                    stroke="#f0e000"
                    stroke-width="8"
                    stroke-linecap="round"
                />
            </svg>
        </div>

        <div
            ref="colorExpand"
            class="absolute top-1/2 left-1/2 w-0 h-0 bg-primary rounded-full z-0"
            style="transform: translate(-50%, -50%); will-change: transform, width, height, opacity;"
        ></div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import gsap from 'gsap'
import loadingImageFile from '../assets/icon11.png'

const props = defineProps({
    isActuallyLoading: {
        type: Boolean,
        default: true,
    }
})

const loadingImageRef = ref(null) // Ref para la imagen
const progressSvg = ref(null)
const progressCircle = ref(null)
const colorExpand = ref(null)

// Usamos la variable importada para la imagen
const loadingImage = loadingImageFile

let progressTl = null;
let expandTl = null;

const CIRCLE_ANIM_DURATION = 1.5;
const EXPANSION_DURATION = 0.7;

onMounted(() => {
    if (!progressCircle.value || !colorExpand.value || !loadingImageRef.value) return;

    const circle = progressCircle.value;
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    gsap.set(circle, {
        strokeDasharray: circumference,
        strokeDashoffset: circumference,
        opacity: 0, // Empezar invisible y luego fade in
    });
    gsap.set(loadingImageRef.value, { opacity: 1 }); // Asegurar que la imagen sea visible
    gsap.set(colorExpand.value, {
        width: 0,
        height: 0,
        opacity: 0,
    });

    progressTl = gsap.timeline({
        repeat: -1,
    });

    progressTl.set(circle, { strokeDashoffset: circumference }) // Resetear para cada repetición
              .to(circle, { opacity: 1, duration: 0.3 })
              .to(circle, {
                  strokeDashoffset: 0,
                  duration: CIRCLE_ANIM_DURATION,
                  ease: 'power1.inOut',
              })
              .to(circle, { opacity: 0, duration: 0.3 }, `+=${CIRCLE_ANIM_DURATION * 0.2}`); // Fade out un poco después de completar

    // Observar cuando la carga real termina para iniciar la expansión
    watch(() => props.isActuallyLoading, (newValue, oldValue) => {
        if (oldValue === true && newValue === false) {
            // La carga ha terminado, iniciar la transición final
            triggerFinalTransition();
        }
    });

    // Si el componente se monta y la carga ya ha terminado (caso raro)
    if (!props.isActuallyLoading) {
        triggerFinalTransition(true); // true para indicar que es inmediato
    }
});

function triggerFinalTransition(immediate = false) {
    if (!colorExpand.value || !progressCircle.value || !loadingImageRef.value) return;

    if (progressTl) {
        progressTl.kill();
    }
    gsap.to([progressCircle.value, loadingImageRef.value], {
        opacity: 0,
        onComplete: () => {
            startColorExpansion(immediate);
        }
    });
}

function startColorExpansion(immediate = false) {
    if (!colorExpand.value) return;

    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;
    const maxDiameter = Math.sqrt(screenWidth * screenWidth + screenHeight * screenHeight) * 1.05; // 5% extra para asegurar cobertura

    expandTl = gsap.timeline();
    expandTl.to(colorExpand.value, {
        width: maxDiameter,
        height: maxDiameter,
        opacity: 1,
        duration: immediate ? 0.01 : EXPANSION_DURATION,
        ease: 'power2.inOut',

    });
}

onUnmounted(() => {
    if (progressTl) progressTl.kill();
    if (expandTl) expandTl.kill();
    gsap.killTweensOf([progressCircle.value, loadingImageRef.value, colorExpand.value]);
});

</script>
