<template>
    <Pie
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />

</template>

<script setup>

import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { computed } from 'vue';
import { useProjectStore } from '../../store/projectStore'

ChartJS.register(ArcElement, Tooltip, Legend)
const projectStore = useProjectStore()
const chartLabels = computed(() => projectStore.damageArea.map(item => item.name))
const chartValues = computed(() => projectStore.damageArea.map(item => item.data))

const chartData = computed(() => ({
    labels: chartLabels.value,
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
}
</script>