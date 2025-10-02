<template>
    <Pie
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />

</template>

<script setup>

import { Chart as ChartJS, ArcElement, Tooltip, Legend, plugins } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { computed, onMounted } from 'vue';

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
    severityData: {
        type: Object,
        required: true
    }
})

const chartValues = computed(() => Object.values(props.severityData));

const chartData = computed(() => ({
    labels: Object.keys(props.severityData),
    datasets: [
        {
            data: chartValues.value,
            backgroundColor: ['#4B5563', '#D1FAE5', '#FBBF24', '#F87171'],
            hoverOffset: 4,
            borderWidth: 0,
        }
    ]
}))

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        Legend: {
            position: 'bottom'
        },
        tooltip: {
            enabled: true,
            mode: 'index',
            intersect: false,
        }
    }
}
</script>