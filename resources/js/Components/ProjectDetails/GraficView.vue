<!-- GraficView.vue -->
<template>
  <div class="w-full h-full flex">
    <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  plugins
} from 'chart.js'
import { computed } from 'vue'
import { useProjectStore } from '../../store/projectStore'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const projectStore = useProjectStore()

// Crea labels y valores desde projectStore.chart
const chartLabels = computed(() => projectStore.chart.map(item => item.name))
const chartValues = computed(() => projectStore.chart.map(item => item.count))

const chartData = computed(() => ({
  labels: chartLabels.value,
  datasets: [
    {
      data: chartValues.value,
      barThickness: 20,
      backgroundColor: '#4B5563',
      borderRadius: 5,
    }
  ]
}))

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    tooltip: {
      callbacks: {
        label: function(tooltipItem) {
          return tooltipItem.raw
        }
      }
    }
  },
  scales: {
    x: {
      title: {
        display: false
      },
      grid: {
        display: false,
        drawBorder: false,
      }
    },
    y: {
      grid: {
        display: false,
        drawBorder: false,
      }
    }
  }
}
</script>
