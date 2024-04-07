<script>
import VueApexCharts from 'vue3-apexcharts'
import api from '@/stores/api'
export default {
  components: {
    VueApexCharts
  },
  data() {
    return {
      chartData: {
        series: [44, 55, 41, 17, 15],
        labels: ['A', 'B', 'C', 'D', 'E'],
        percentage: [65, 65, 65, 65]
      },
      apexOptions: {
        chart: {
          type: 'donut',
          width: 380
        },
        colors: ['#3C50E0', '#6577F3', '#8FD0EF', '#0FADCF'],
        labels: [],
        legend: {
          show: false,
          position: 'bottom'
        },
        plotOptions: {
          pie: {
            donut: {
              size: '65%',
              background: 'transparent'
            }
          }
        },
        dataLabels: {
          enabled: false
        },
        responsive: [
          {
            breakpoint: 640,
            options: {
              chart: {
                width: 200
              }
            }
          }
        ]
      }
    }
  },
  mounted() {
    // this.apexOptions.labels = this.chartData.labels
    this.fetchData()
  },
  methods: {
    fetchData() {
      api.get('stats/roles').then((response) => {
        this.chartData = response.data
        this.chartData.percentage = response.data.percentage
        this.chartData.series = response.data.count
        this.$refs.chart.updateOptions({
          labels: response.data.roles
        })
      })
    }
  }
}
</script>
<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-4"
  >
    <div class="mb-3 justify-between gap-4 sm:flex">
      <div>
        <h4 class="text-xl font-bold text-black dark:text-white">Roles Analytics</h4>
      </div>
    </div>
    <div class="mb-2">
      <div id="chartThree" class="mx-auto flex justify-center">
        <VueApexCharts
          type="donut"
          width="340"
          :options="apexOptions"
          :series="chartData.series"
          ref="chart"
        />
      </div>
    </div>
    <div class="-mx-8 flex flex-wrap items-center justify-center gap-y-3">
      <div class="w-full px-8 sm:w-1/2" v-for="item in chartData.percentage" :key="item.id">
        <div class="flex w-full items-center">
          <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-primary"></span>
          <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
            <span> {{ item.role }}s </span>
            <span> {{ item.percentage }} % </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
