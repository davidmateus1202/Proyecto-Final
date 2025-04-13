<template>
    <Pie
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />

</template>

<script>

import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

export default {
    name: 'PieGraficView',
    components: { Pie },
    data() {
        return {
            chartData: {
                lablels: ['Sano', 'Dañado'],
                datasets: [
                    {
                        data: [40, 60],
                        backgroundColor: ['#4B5563', '#FBBF24'],
                        hoverOffset: 4,
                        borderWidth: 0,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            }
        }
    }
}

</script>