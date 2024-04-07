<script>
export default {
  setup() {
    return {
      brandData: [
        {
          name: 'Brand 1',
          visitors: 12,
          revenues: 120,
          sales: 10,
          conversion: 20
        },
        {
          name: 'Brand 2',
          visitors: 10,
          revenues: 100,
          sales: 8,
          conversion: 18
        },
        {
          name: 'Brand 3',
          visitors: 8,
          revenues: 80,
          sales: 6,
          conversion: 16
        },
        {
          name: 'Brand 4',
          visitors: 6,
          revenues: 60,
          sales: 4,
          conversion: 14
        },
        {
          name: 'Brand 5',
          visitors: 4,
          revenues: 40,
          sales: 2,
          conversion: 12
        }
      ]
    }
  }
}
</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">Top Associations</h4>

    <div class="flex flex-col">
      <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
        <div class="p-2.5 xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Source</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Visitors</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Revenues</h5>
        </div>
        <div class="hidden p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Sales</h5>
        </div>
        <div class="hidden p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Conversion</h5>
        </div>
      </div>

      <div
        v-for="(brand, key) in brandData"
        :key="key"
        :class="`grid grid-cols-3 sm:grid-cols-5 ${
          key === brandData.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'
        }`"
      >
        <div class="flex items-center gap-3 p-2.5 xl:p-5">
          <!-- <div class="flex-shrink-0">
            <img :src="brand.logo" alt="Brand" />
          </div> -->
          <p class="hidden text-black dark:text-white sm:block">{{ brand.name }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-black dark:text-white">{{ brand.visitors }}K</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-meta-3">${{ brand.revenues }}</p>
        </div>

        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
          <p class="text-black dark:text-white">{{ brand.sales }}</p>
        </div>

        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
          <p class="text-meta-5">{{ brand.conversion }}%</p>
        </div>
      </div>
    </div>
  </div>
</template>
