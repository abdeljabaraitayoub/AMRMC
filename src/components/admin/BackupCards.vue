<script>
import api from '@/stores/api'
export default {
  components: {},
  data() {
    return {
      entity: 'activities',
      packages: [],
      page: 1,
      pages: 0
    }
  },
  watch: {
    page() {
      this.fetchdata()
    }
  },
  mounted() {
    this.fetchdata()
  },
  methods: {
    fetchdata() {
      api.get(`/${this.entity}?page=${this.page}`).then((response) => {
        this.packages = response.data.data
        this.pages = response.data.meta.last_page
      })
    },

    deleteItem(id) {
      api.delete(`/${this.entity}/${id}`).then(() => {
        this.packages = this.packages.filter((item) => item.id !== id)
      })
    }
  }
}
</script>
<template>
  <div>
    <div
      class="col-span-12 rounded-lg border border-stroke bg-white px-5 pt-7.5 w-100 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
    >
      <div><h4 class="text-xl font-bold text-black dark:text-white">Visitors Analytics</h4></div>

      <div style="display: flex; justify-content: center; align-items: center; height: 200.033px">
        <i class="bi hover:text-primary bi-database-check" style="font-size: 125px"></i>
      </div>
    </div>

    <div
      class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
    >
      <div class="mb-3 justify-between gap-4 sm:flex">
        <div><h4 class="text-xl font-bold text-black dark:text-white">Visitors Analytics</h4></div>
        <div>
          <div class="relative z-20 inline-block">
            <select
              name=""
              id=""
              class="relative z-20 inline-flex appearance-none bg-transparent py-1 pl-3 pr-8 text-sm font-medium outline-none"
            >
              <option value="">Monthly</option>
              <option value="">Yearly</option></select
            ><span class="absolute top-1/2 right-3 z-10 -translate-y-1/2"
              ><svg
                width="10"
                height="6"
                viewBox="0 0 10 6"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.47072 1.08816C0.47072 1.02932 0.500141 0.955772 0.54427 0.911642C0.647241 0.808672 0.809051 0.808672 0.912022 0.896932L4.85431 4.60386C4.92785 4.67741 5.06025 4.67741 5.14851 4.60386L9.09079 0.896932C9.19376 0.793962 9.35557 0.808672 9.45854 0.911642C9.56151 1.01461 9.5468 1.17642 9.44383 1.27939L5.50155 4.98632C5.22206 5.23639 4.78076 5.23639 4.51598 4.98632L0.558981 1.27939C0.50014 1.22055 0.47072 1.16171 0.47072 1.08816Z"
                  fill="#637381"
                ></path>
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M1.22659 0.546578L5.00141 4.09604L8.76422 0.557869C9.08459 0.244537 9.54201 0.329403 9.79139 0.578788C10.112 0.899434 10.0277 1.36122 9.77668 1.61224L9.76644 1.62248L5.81552 5.33722C5.36257 5.74249 4.6445 5.7544 4.19352 5.32924C4.19327 5.32901 4.19377 5.32948 4.19352 5.32924L0.225953 1.61241C0.102762 1.48922 -4.20186e-08 1.31674 -3.20269e-08 1.08816C-2.40601e-08 0.905899 0.0780105 0.712197 0.211421 0.578787C0.494701 0.295506 0.935574 0.297138 1.21836 0.539529L1.22659 0.546578ZM4.51598 4.98632C4.78076 5.23639 5.22206 5.23639 5.50155 4.98632L9.44383 1.27939C9.5468 1.17642 9.56151 1.01461 9.45854 0.911642C9.35557 0.808672 9.19376 0.793962 9.09079 0.896932L5.14851 4.60386C5.06025 4.67741 4.92785 4.67741 4.85431 4.60386L0.912022 0.896932C0.809051 0.808672 0.647241 0.808672 0.54427 0.911642C0.500141 0.955772 0.47072 1.02932 0.47072 1.08816C0.47072 1.16171 0.50014 1.22055 0.558981 1.27939L4.51598 4.98632Z"
                  fill="#637381"
                ></path></svg
            ></span>
          </div>
        </div>
      </div>
      <div class="mb-2">
        <div id="chartThree" class="mx-auto flex justify-center">
          <div class="vue-apexcharts" style="min-height: 262.033px">
            <div
              id="apexchartspzb5vfrq"
              class="apexcharts-canvas apexchartspzb5vfrq apexcharts-theme-light"
              style="width: 340px; height: 262.033px"
            >
              <svg
                id="SvgjsSvg1657"
                width="340"
                height="262.03333333333336"
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:svgjs="http://svgjs.dev"
                class="apexcharts-svg"
                xmlns:data="ApexChartsNS"
                transform="translate(0, 0)"
                style="background: transparent"
              >
                <foreignObject x="0" y="0" width="340" height="262.03333333333336"
                  ><div
                    class="apexcharts-legend"
                    xmlns="http://www.w3.org/1999/xhtml"
                    style="max-height: 141.667px"
                  ></div
                ></foreignObject>
                <g
                  id="SvgjsG1659"
                  class="apexcharts-inner apexcharts-graphical"
                  transform="translate(41.333333333333314, 0)"
                >
                  <defs id="SvgjsDefs1658">
                    <clipPath id="gridRectMaskpzb5vfrq">
                      <rect
                        id="SvgjsRect1660"
                        width="265.33333333333337"
                        height="293.33333333333337"
                        x="-4"
                        y="-6"
                        rx="0"
                        ry="0"
                        opacity="1"
                        stroke-width="0"
                        stroke="none"
                        stroke-dasharray="0"
                        fill="#fff"
                      ></rect>
                    </clipPath>
                    <clipPath id="forecastMaskpzb5vfrq"></clipPath>
                    <clipPath id="nonForecastMaskpzb5vfrq"></clipPath>
                    <clipPath id="gridRectMarkerMaskpzb5vfrq">
                      <rect
                        id="SvgjsRect1661"
                        width="263.33333333333337"
                        height="285.33333333333337"
                        x="-2"
                        y="-2"
                        rx="0"
                        ry="0"
                        opacity="1"
                        stroke-width="0"
                        stroke="none"
                        stroke-dasharray="0"
                        fill="#fff"
                      ></rect>
                    </clipPath>
                  </defs>
                  <g id="SvgjsG1662" class="apexcharts-pie">
                    <g id="SvgjsG1663" transform="translate(0, 0) scale(1)">
                      <circle
                        id="SvgjsCircle1664"
                        r="78.32764227642278"
                        cx="129.66666666666669"
                        cy="129.66666666666669"
                        fill="transparent"
                      ></circle>
                      <g id="SvgjsG1665" class="apexcharts-slices">
                        <g
                          id="SvgjsG1666"
                          class="apexcharts-series apexcharts-pie-series"
                          seriesName="Desktop"
                          rel="1"
                          data:realIndex="0"
                        >
                          <path
                            id="SvgjsPath1667"
                            d="M 129.66666666666669 9.162601626016254 A 120.50406504065043 120.50406504065043 0 0 1 189.91869918699192 234.02624825116223 L 168.8304878048781 197.50039469658878 A 78.32764227642278 78.32764227642278 0 0 0 129.66666666666669 51.33902439024391 L 129.66666666666669 9.162601626016254 z "
                            fill="rgba(60,80,224,1)"
                            fill-opacity="1"
                            stroke-opacity="1"
                            stroke-linecap="butt"
                            stroke-width="2"
                            stroke-dasharray="0"
                            class="apexcharts-pie-area apexcharts-donut-slice-0"
                            index="0"
                            j="0"
                            data:angle="150"
                            data:startAngle="0"
                            data:strokeWidth="2"
                            data:value="65"
                            data:pathOrig="M 129.66666666666669 9.162601626016254 A 120.50406504065043 120.50406504065043 0 0 1 189.91869918699192 234.02624825116223 L 168.8304878048781 197.50039469658878 A 78.32764227642278 78.32764227642278 0 0 0 129.66666666666669 51.33902439024391 L 129.66666666666669 9.162601626016254 z "
                            stroke="#ffffff"
                          ></path>
                        </g>
                        <g
                          id="SvgjsG1668"
                          class="apexcharts-series apexcharts-pie-series"
                          seriesName="Tablet"
                          rel="2"
                          data:realIndex="1"
                        >
                          <path
                            id="SvgjsPath1669"
                            d="M 189.91869918699192 234.02624825116223 A 120.50406504065043 120.50406504065043 0 0 1 39.46807878543039 209.57564260524447 L 71.03758454386309 181.60750102674226 A 78.32764227642278 78.32764227642278 0 0 0 168.8304878048781 197.50039469658878 L 189.91869918699192 234.02624825116223 z "
                            fill="rgba(101,119,243,1)"
                            fill-opacity="1"
                            stroke-opacity="1"
                            stroke-linecap="butt"
                            stroke-width="2"
                            stroke-dasharray="0"
                            class="apexcharts-pie-area apexcharts-donut-slice-1"
                            index="0"
                            j="1"
                            data:angle="78.46153846153845"
                            data:startAngle="150"
                            data:strokeWidth="2"
                            data:value="34"
                            data:pathOrig="M 189.91869918699192 234.02624825116223 A 120.50406504065043 120.50406504065043 0 0 1 39.46807878543039 209.57564260524447 L 71.03758454386309 181.60750102674226 A 78.32764227642278 78.32764227642278 0 0 0 168.8304878048781 197.50039469658878 L 189.91869918699192 234.02624825116223 z "
                            stroke="#ffffff"
                          ></path>
                        </g>
                        <g
                          id="SvgjsG1670"
                          class="apexcharts-series apexcharts-pie-series"
                          seriesName="Mobile"
                          rel="3"
                          data:realIndex="2"
                        >
                          <path
                            id="SvgjsPath1671"
                            d="M 39.46807878543039 209.57564260524447 A 120.50406504065043 120.50406504065043 0 0 1 73.66563531680694 22.96561616071648 L 93.26599628925786 60.31098383779906 A 78.32764227642278 78.32764227642278 0 0 0 71.03758454386309 181.60750102674226 L 39.46807878543039 209.57564260524447 z "
                            fill="rgba(143,208,239,1)"
                            fill-opacity="1"
                            stroke-opacity="1"
                            stroke-linecap="butt"
                            stroke-width="2"
                            stroke-dasharray="0"
                            class="apexcharts-pie-area apexcharts-donut-slice-2"
                            index="0"
                            j="2"
                            data:angle="103.84615384615381"
                            data:startAngle="228.46153846153845"
                            data:strokeWidth="2"
                            data:value="45"
                            data:pathOrig="M 39.46807878543039 209.57564260524447 A 120.50406504065043 120.50406504065043 0 0 1 73.66563531680694 22.96561616071648 L 93.26599628925786 60.31098383779906 A 78.32764227642278 78.32764227642278 0 0 0 71.03758454386309 181.60750102674226 L 39.46807878543039 209.57564260524447 z "
                            stroke="#ffffff"
                          ></path>
                        </g>
                        <g
                          id="SvgjsG1672"
                          class="apexcharts-series apexcharts-pie-series"
                          seriesName="Unknown"
                          rel="4"
                          data:realIndex="3"
                        >
                          <path
                            id="SvgjsPath1673"
                            d="M 73.66563531680694 22.96561616071648 A 120.50406504065043 120.50406504065043 0 0 1 129.64563473980348 9.162603461398106 L 129.6529959142056 51.33902558324212 A 78.32764227642278 78.32764227642278 0 0 0 93.26599628925786 60.31098383779906 L 73.66563531680694 22.96561616071648 z "
                            fill="rgba(15,173,207,1)"
                            fill-opacity="1"
                            stroke-opacity="1"
                            stroke-linecap="butt"
                            stroke-width="2"
                            stroke-dasharray="0"
                            class="apexcharts-pie-area apexcharts-donut-slice-3"
                            index="0"
                            j="3"
                            data:angle="27.69230769230768"
                            data:startAngle="332.30769230769226"
                            data:strokeWidth="2"
                            data:value="12"
                            data:pathOrig="M 73.66563531680694 22.96561616071648 A 120.50406504065043 120.50406504065043 0 0 1 129.64563473980348 9.162603461398106 L 129.6529959142056 51.33902558324212 A 78.32764227642278 78.32764227642278 0 0 0 93.26599628925786 60.31098383779906 L 73.66563531680694 22.96561616071648 z "
                            stroke="#ffffff"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                  <line
                    id="SvgjsLine1674"
                    x1="0"
                    y1="0"
                    x2="259.33333333333337"
                    y2="0"
                    stroke="#b6b6b6"
                    stroke-dasharray="0"
                    stroke-width="1"
                    stroke-linecap="butt"
                    class="apexcharts-ycrosshairs"
                  ></line>
                  <line
                    id="SvgjsLine1675"
                    x1="0"
                    y1="0"
                    x2="259.33333333333337"
                    y2="0"
                    stroke-dasharray="0"
                    stroke-width="0"
                    stroke-linecap="butt"
                    class="apexcharts-ycrosshairs-hidden"
                  ></line>
                </g>
              </svg>
              <div class="apexcharts-tooltip apexcharts-theme-dark">
                <div class="apexcharts-tooltip-series-group" style="order: 1">
                  <span
                    class="apexcharts-tooltip-marker"
                    style="background-color: rgb(60, 80, 224)"
                  ></span>
                  <div
                    class="apexcharts-tooltip-text"
                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px"
                  >
                    <div class="apexcharts-tooltip-y-group">
                      <span class="apexcharts-tooltip-text-y-label"></span
                      ><span class="apexcharts-tooltip-text-y-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-goals-group">
                      <span class="apexcharts-tooltip-text-goals-label"></span
                      ><span class="apexcharts-tooltip-text-goals-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-z-group">
                      <span class="apexcharts-tooltip-text-z-label"></span
                      ><span class="apexcharts-tooltip-text-z-value"></span>
                    </div>
                  </div>
                </div>
                <div class="apexcharts-tooltip-series-group" style="order: 2">
                  <span
                    class="apexcharts-tooltip-marker"
                    style="background-color: rgb(101, 119, 243)"
                  ></span>
                  <div
                    class="apexcharts-tooltip-text"
                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px"
                  >
                    <div class="apexcharts-tooltip-y-group">
                      <span class="apexcharts-tooltip-text-y-label"></span
                      ><span class="apexcharts-tooltip-text-y-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-goals-group">
                      <span class="apexcharts-tooltip-text-goals-label"></span
                      ><span class="apexcharts-tooltip-text-goals-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-z-group">
                      <span class="apexcharts-tooltip-text-z-label"></span
                      ><span class="apexcharts-tooltip-text-z-value"></span>
                    </div>
                  </div>
                </div>
                <div class="apexcharts-tooltip-series-group" style="order: 3">
                  <span
                    class="apexcharts-tooltip-marker"
                    style="background-color: rgb(143, 208, 239)"
                  ></span>
                  <div
                    class="apexcharts-tooltip-text"
                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px"
                  >
                    <div class="apexcharts-tooltip-y-group">
                      <span class="apexcharts-tooltip-text-y-label"></span
                      ><span class="apexcharts-tooltip-text-y-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-goals-group">
                      <span class="apexcharts-tooltip-text-goals-label"></span
                      ><span class="apexcharts-tooltip-text-goals-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-z-group">
                      <span class="apexcharts-tooltip-text-z-label"></span
                      ><span class="apexcharts-tooltip-text-z-value"></span>
                    </div>
                  </div>
                </div>
                <div class="apexcharts-tooltip-series-group" style="order: 4">
                  <span
                    class="apexcharts-tooltip-marker"
                    style="background-color: rgb(15, 173, 207)"
                  ></span>
                  <div
                    class="apexcharts-tooltip-text"
                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px"
                  >
                    <div class="apexcharts-tooltip-y-group">
                      <span class="apexcharts-tooltip-text-y-label"></span
                      ><span class="apexcharts-tooltip-text-y-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-goals-group">
                      <span class="apexcharts-tooltip-text-goals-label"></span
                      ><span class="apexcharts-tooltip-text-goals-value"></span>
                    </div>
                    <div class="apexcharts-tooltip-z-group">
                      <span class="apexcharts-tooltip-text-z-label"></span
                      ><span class="apexcharts-tooltip-text-z-value"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="-mx-8 flex flex-wrap items-center justify-center gap-y-3">
        <div class="w-full px-8 sm:w-1/2">
          <div class="flex w-full items-center">
            <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-primary"></span>
            <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
              <span> Desktop </span><span> 65% </span>
            </p>
          </div>
        </div>
        <div class="w-full px-8 sm:w-1/2">
          <div class="flex w-full items-center">
            <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#6577F3]"></span>
            <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
              <span> Tablet </span><span> 34% </span>
            </p>
          </div>
        </div>
        <div class="w-full px-8 sm:w-1/2">
          <div class="flex w-full items-center">
            <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#8FD0EF]"></span>
            <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
              <span> Mobile </span><span> 45% </span>
            </p>
          </div>
        </div>
        <div class="w-full px-8 sm:w-1/2">
          <div class="flex w-full items-center">
            <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-[#0FADCF]"></span>
            <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
              <span> Unknown </span><span> 12% </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
