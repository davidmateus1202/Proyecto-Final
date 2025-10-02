<template>
    <div class="flex flex-col w-full h-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-primary mb-6">Detalles Generales del Proyecto</h2>

        <!-- Resumen del Proyecto -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Nombre del Proyecto</p>
                <p class="text-xl font-semibold text-gray-800">{{ projectStore.projectSelected?.name || 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Estado del Proyecto</p>
                <p class="text-xl font-semibold" :class="projectStore.projectSelected?.status === 'finished' ? 'text-green-600' : 'text-yellow-600'">
                    {{ formatProjectStatus(projectStore.projectSelected?.status) || 'N/A' }}
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm col-span-full lg:col-span-1">
                <p class="text-sm text-gray-500">Descripción</p>
                <p class="text-base text-gray-700">{{ projectStore.projectSelected?.description || 'No disponible' }}</p>
            </div>
            <!-- Añade más detalles como fechas o un mapa pequeño si lo deseas -->
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-5">Estadísticas Clave del Proyecto</h3>

        <!-- Sección de KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="flex flex-col items-center p-5 bg-blue-50 rounded-lg shadow-sm">
                <span class="text-4xl font-extrabold text-blue-700">{{ totalAbscisas }}</span>
                <span class="text-base text-blue-600 mt-2">Total Abscisas</span>
            </div>
            <div class="flex flex-col items-center p-5 bg-orange-50 rounded-lg shadow-sm">
                <span class="text-4xl font-extrabold text-orange-700">{{ totalSlabsConPatologias }}</span>
                <span class="text-base text-orange-600 mt-2">Placas con Patologías</span>
            </div>
            <div class="flex flex-col items-center p-5 bg-red-50 rounded-lg shadow-sm">
                <span class="text-4xl font-extrabold text-red-700">{{ totalPatologias }}</span>
                <span class="text-base text-red-600 mt-2">Total Patologías</span>
            </div>
        </div>

        <!-- Gráficos de Resumen -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Patologías por Severidad</h4>
                <!-- Aquí puedes integrar un gráfico circular (Chart.js, ApexCharts, etc.) -->
                <div v-if="Object.keys(patologiasPorSeveridad).length === 0" class="text-center text-gray-500 h-48 flex items-center justify-center">
                    No hay patologías registradas.
                </div>
                <div v-else class="h-48 flex items-center justify-center">
                    <!-- Ejemplo de un "gráfico" muy básico con CSS para visualización -->
                    <PieGraficSeverity :severityData="patologiasPorSeveridad" />
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Tipos de Patologías Más Comunes</h4>
                <div v-if="tiposPatologiasComunes.length === 0" class="text-center text-gray-500 h-48 flex items-center justify-center">
                    No hay patologías registradas.
                </div>
                <ul v-else class="list-disc pl-5">
                    <li v-for="(item, index) in tiposPatologiasComunes" :key="index" class="text-gray-700 text-base mb-2">
                        {{ item.name }} ({{ item.count }} veces)
                    </li>
                </ul>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-800">Ruta del proyecto</h3>
        <span class="text-gray-400 mb-5">En el mapa podras visualizar la ruta del proyecto.</span>
        <GooglePath
            v-if="lastSlab"
            :initialLatitude="parseFloat(projectStore.projectDetails[0].slabs_with_pathologies[0].latitude)"
            :initialLongitude="parseFloat(projectStore.projectDetails[0].slabs_with_pathologies[0].longitude)"
            :destinationLatitude="parseFloat(lastSlab.latitude)"
            :destinationLongitude="parseFloat(lastSlab.longitude)"
        />

    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useProjectStore } from '../../store/projectStore'; // Ajusta la ruta
import PieGraficSeverity from './PieGraficSeverity.vue';
import GooglePath from '../GooglePath.vue';

const projectStore = useProjectStore();
const lastSlab = computed(() => {
    if (projectStore.projectDetails && projectStore.projectDetails.length > 0) {
        const lastAbscisa = projectStore.projectDetails[projectStore.projectDetails.length - 1];

        if (lastAbscisa.slabs_with_pathologies && lastAbscisa.slabs_with_pathologies.length > 0) {
            return lastAbscisa.slabs_with_pathologies[lastAbscisa.slabs_with_pathologies.length - 1];
        }
    }
    return null;
})


const totalAbscisas = computed(() => projectStore.projectDetails.length);

const totalSlabsConPatologias = computed(() => {
    let count = 0;
    projectStore.projectDetails.forEach(abscisa => {
        count += abscisa.slabs_with_pathologies ? abscisa.slabs_with_pathologies.length : 0;
    });
    return count;
});

const totalPatologias = computed(() => {
    let count = 0;
    projectStore.projectDetails.forEach(abscisa => {
        abscisa.slabs_with_pathologies?.forEach(slab => {
            count += slab.pathologies ? slab.pathologies.length : 0;
        });
    });
    return count;
});

const patologiasPorSeveridad = computed(() => {
    const severityCounts = {
        'low': 0,
        'half': 0,
        'high': 0,
        // Añade otras severidades si existen en tus datos
    };
    projectStore.projectDetails.forEach(abscisa => {
        abscisa.slabs_with_pathologies?.forEach(slab => {
            slab.pathologies?.forEach(pathology => {
                if (severityCounts.hasOwnProperty(pathology.type_damage)) {
                    severityCounts[pathology.type_damage]++;
                }
            });
        });
    });
    // Devuelve solo las severidades que tienen un conteo > 0
    return Object.fromEntries(
        Object.entries(severityCounts).filter(([, count]) => count > 0)
    );
});

const tiposPatologiasComunes = computed(() => {
    const pathologyTypeCounts = {};
    projectStore.projectDetails.forEach(abscisa => {
        abscisa.slabs_with_pathologies?.forEach(slab => {
            slab.pathologies?.forEach(pathology => {
                const name = pathology.name;
                pathologyTypeCounts[name] = (pathologyTypeCounts[name] || 0) + 1;
            });
        });
    });

    const sortedTypes = Object.entries(pathologyTypeCounts)
        .map(([name, count]) => ({ name, count }))
        .sort((a, b) => b.count - a.count); // Ordenar de mayor a menor

    return sortedTypes.slice(0, 5); // Tomar los 5 tipos más comunes
});

// --- Funciones de Formato ---

const formatProjectStatus = (status) => {
    switch (status) {
        case 'in_progress': return 'En Proceso';
        case 'finished': return 'Finalizado';
        default: return 'Desconocido';
    }
};

const getSeverityColorClass = (severity) => {
    switch (severity) {
        case 'Baja': return 'bg-green-400';
        case 'Media': return 'bg-yellow-400';
        case 'Alta': return 'bg-red-400';
        default: return 'bg-gray-400';
    }
};

</script>