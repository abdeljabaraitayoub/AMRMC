<script>
import { ref } from 'vue'
import { reactive } from 'vue'
import VueApexCharts from 'vue3-apexcharts'
import api from '@/stores/api'

export default {
  setup() {
    const chartData = reactive({
      series: [
        {
          name: 'patients'
        },
        {
          name: 'users'
        }
      ],
      labels: ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
    })
    const chart = ref(null)

    const apexOptions = ref({
      legend: {
        show: false,
        position: 'top',
        horizontalAlign: 'left'
      },
      colors: ['#3C50E0', '#80CAEE'],
      chart: {
        fontFamily: 'Satoshi, sans-serif',
        height: 335,
        type: 'area',
        dropShadow: {
          enabled: true,
          color: '#623CEA14',
          top: 10,
          blur: 4,
          left: 0,
          opacity: 0.1
        },
        toolbar: {
          show: false
        }
      },
      responsive: [
        {
          breakpoint: 1024,
          options: {
            chart: {
              height: 300
            }
          }
        },
        {
          breakpoint: 1366,
          options: {
            chart: {
              height: 350
            }
          }
        }
      ],
      stroke: {
        width: [2, 2],
        curve: 'straight'
      },
      labels: {
        show: false,
        position: 'top'
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 4,
        colors: '#fff',
        strokeColors: ['#3056D3', '#80CAEE'],
        strokeWidth: 3,
        strokeOpacity: 0.9,
        strokeDashArray: 0,
        fillOpacity: 1,
        discrete: [],
        hover: {
          size: undefined,
          sizeOffset: 5
        }
      },
      xaxis: {
        type: 'category',
        categories: chartData.labels,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        title: {
          style: {
            fontSize: '0px'
          }
        },
        min: 0
      }
    })

    return { chartData, chart, apexOptions }
  },
  components: {
    VueApexCharts
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    async fetchData() {
      api.get('/stats/monthly-registrations').then((response) => {
        this.chartData.series[0].data = response.data.patients
        this.chartData.series[1].data = response.data.users
      })
    }
  }
}
</script>

<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-8"
  >
    <div>
      <h4 class="text-xl font-bold text-black dark:text-white">Users Analytics</h4>
    </div>

    <div>
      <div id="chartOne" class="-ml-5">
        <VueApexCharts
          type="area"
          height="350"
          :options="apexOptions"
          :series="chartData.series"
          ref="chart"
        />
      </div>
    </div>
  </div>
</template>
