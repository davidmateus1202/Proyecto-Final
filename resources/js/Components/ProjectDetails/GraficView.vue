<template>
    <div class="w-full h-full flex">
        <Bar
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      chartData: {
        labels: [ 'January', 'February', 'March', 'April', 'May' ],
        datasets: [
             { 
                data: [40, 20, 12, 39, 10],
                barThickness: 20,
                backgroundColor: '#4B5563',
                borderRadius: 5,
            } 
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
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
    }
  }
}
</script>