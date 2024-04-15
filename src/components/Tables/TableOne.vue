<script>
import api from '@/stores/api'
export default {
  data() {
    return {
      Data: []
    }
  },
  methods: {
    fetchData() {
      api.get('stats/associations').then((response) => {
        this.Data = response.data
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
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">Top Associations</h4>

    <div class="flex flex-col">
      <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-3">
        <div class="p-2.5 xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Name</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Description</h5>
        </div>

        <div class="p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Patitents</h5>
        </div>
      </div>

      <div v-for="(brand, key) in Data" :key="key" class="grid grid-cols-3 sm:grid-cols-3">
        <div class="flex items-center gap-3 p-2.5 xl:p-5">
          <!-- <div class="flex-shrink-0">
            <img :src="brand.logo" alt="Brand" />
          </div> -->
          <p class="hidden text-black dark:text-white sm:block">{{ brand.name }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-black dark:text-white">{{ brand.description }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-meta-3">{{ brand.patients_count }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
