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
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <div class="max-w-full overflow-x-auto">
      <table class="w-full table-auto">
        <thead>
          <tr class="bg-gray-2 text-left dark:bg-meta-4">
            <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
              causer
            </th>
            <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">action</th>
            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
              description
            </th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">subject_id</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in packages" :key="index">
            <td class="py-5 px-4 pl-9 xl:pl-11">
              <h5 class="font-medium text-black dark:text-white">{{ item.causer.name }}</h5>
              <p class="text-sm">{{ item.causer.email }}</p>
            </td>
            <td class="py-5 px-4">
              <p class="text-black dark:text-white">{{ item.log_name }}</p>
            </td>
            <td class="py-5 px-4">
              <p class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium">
                {{ item.description }}
              </p>
            </td>
            <td class="py-5 px-4">
              <p class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium">
                {{ item.subject_id }}
              </p>
            </td>
            <td class="py-5 px-4">
              <p class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium">
                {{ item.created_at }}
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div
      class="mt-4.5 w-fit mx-auto mb-5.5 flex rounded-md border border-stroke py-2.5 shadow-1 dark:border-strokedark dark:bg-[#37404F]"
    >
      <button
        :disabled="page <= 1"
        @click="page--"
        class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row"
      >
        <span class="font-semibold text-black dark:text-white">«</span>
      </button>
      <button
        v-for="(item, index) in pages"
        :key="index"
        @click="page = index + 1"
        class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row"
        :class="{ 'opacity-50': page === index + 1 }"
      >
        <span class="text-black font-semibold dark:text-white">{{ index + 1 }}</span>
      </button>
      <button
        :disabled="page == pages"
        @click="page++"
        class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row"
      >
        <span class="font-semibold text-black dark:text-white">»</span>
      </button>
    </div>
  </div>
</template>
