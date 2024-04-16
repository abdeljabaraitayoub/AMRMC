<script>
import api from '@/stores/api'
import LoaderLoop from '@/components/LoaderLoop.vue'
export default {
  components: {
    LoaderLoop
  },
  data() {
    return {
      entity: 'backup',
      packages: [],
      loading: false,
      loadingCreate: false
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
      api.get(`/${this.entity}`).then((response) => {
        this.packages = response.data
        this.loading = true
      })
    },
    deleteItem(id) {
      api.delete(`/${this.entity}/${id}`).then(() => {
        this.packages = this.packages.filter((item) => item.id !== id)
      })
    },
    create() {
      this.loadingCreate = true
      api.post(`/${this.entity}`).then(() => {
        this.fetchdata()
        this.loadingCreate = false
      })
    }
  }
}
</script>
<template>
  <div v-if="loading" class="flex justify-around flex-wrap">
    <div
      class="col-span-12 rounded-lg border mb-10 opacity-90 border-stroke bg-white px-5 pt-7.5 w-100 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
    >
      <div><h4 class="text-xl font-bold text-black dark:text-white">Create Backup</h4></div>

      <LoaderLoop v-if="loadingCreate" class="flex items-center mt-13 justify-center" />
      <div
        v-if="!loadingCreate"
        @click="create"
        style="display: flex; justify-content: center; align-items: center; height: 200.033px"
      >
        <i class="bi hover:text-primary bi-database-add" style="font-size: 125px"></i>
      </div>
    </div>
    <div
      v-for="item in packages"
      :key="item.id"
      class="col-span-12 rounded-lg border mb-10 border-stroke bg-white px-5 pt-7.5 w-100 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5"
    >
      <a :href="item.url">
        <div>
          <h4 class="text-xl font-bold text-black dark:text-white">{{ item.name }}</h4>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; height: 200.033px">
          <i class="bi hover:text-primary bi-database-check" style="font-size: 125px"></i>
        </div>
      </a>
    </div>
  </div>
</template>
