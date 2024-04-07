<script lang="ts">
import VueApexCharts from 'vue3-apexcharts'
import api from '@/stores/api'
export default {
  components: {
    VueApexCharts
  },
  data() {
    return {
      chartData: {
        series: [
          {
            name: 'patients',
            data: [1, 2, 3]
          }
        ],
        labels: []
      },
      apexOptions: {
        colors: ['#3056D3', '#80CAEE'],
        chart: {
          type: 'bar',
          height: 335,
          stacked: true,
          toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          }
        },
        responsive: [
          {
            breakpoint: 1536,
            options: {
              plotOptions: {
                bar: {
                  borderRadius: 0,
                  columnWidth: '25%'
                }
              }
            }
          }
        ],
        plotOptions: {
          bar: {
            horizontal: false,
            borderRadius: 0,
            columnWidth: '25%',
            borderRadiusApplication: 'end',
            borderRadiusWhenStacked: 'last'
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          type: 'category',
          categories: []
        },
        legend: {
          position: 'top',
          horizontalAlign: 'left',
          fontFamily: 'Satoshi',
          fontWeight: 500,
          fontSize: '14px',
          markers: {
            radius: 99
          }
        },
        fill: {
          opacity: 1
        }
      }
    }
  },
  methods: {
    fetchData() {
      api.get('stats/patients-disease').then((response) => {
        this.apexOptions.xaxis.categories = response.data.names
        this.chartData.series[0].data = response.data.diseases
        this.$refs.chart.updateOptions(this.apexOptions)
      })
    }
  },
  mounted() {
    this.fetchData()
  }
}
</script>
<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white p-7.5 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-9"
  >
    <div class="mb-4 justify-between gap-4 sm:flex">
      <div>
        <h4 class="text-xl font-bold text-black dark:text-white">Disease Prevalence</h4>
      </div>
    </div>

    <div>
      <div id="chartTwo" class="-ml-5 -mb-9">
        <VueApexCharts
          type="bar"
          height="335"
          :options="apexOptions"
          :series="chartData.series"
          ref="chart"
        />
      </div>
    </div>
  </div>
</template>
