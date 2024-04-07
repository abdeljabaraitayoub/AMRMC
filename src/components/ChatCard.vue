<script>
import api from '@/stores/api'
export default {
  data() {
    return {
      data: []
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      api.get('activities').then((response) => {
        this.data = response.data.data

        console.log(response.data.data[0].causer.image)
      })
    }
  }
}
</script>

<template>
  <div
    class="col-span-12 rounded-sm border border-stroke bg-white py-6 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-3"
  >
    <h4 class="mb-6 px-7.5 text-xl font-semibold text-black dark:text-white">Activities</h4>
    <div>
      <div
        v-for="item in data"
        :key="item.id"
        aria-current="page"
        class="router-link-active router-link-exact-active flex items-center gap-5 py-3 px-7.5 hover:bg-gray-3 dark:hover:bg-meta-4"
      >
        <div class="relative h-14 w-14 rounded-full">
          <img class="h-14 w-14 rounded-full" :src="item.causer.image" alt="User" /><span
            class="absolute right-0 bottom-0 h-3.5 w-3.5 rounded-full"
          ></span>
        </div>
        <div class="flex flex-1 items-center justify-between">
          <div>
            <h5 class="font-medium text-black dark:text-white">{{ item.causer.name }}</h5>
            <p>
              <span class="text-sm text-black dark:text-white">{{ item.log_name }}</span
              ><span class="text-xs"> . {{ item.time_passed }}</span>
            </p>
          </div>
          <!-- <div class="flex h-6 w-6 items-center justify-center rounded-full bg-primary">
            <span class="text-sm font-medium text-white">3</span>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>
