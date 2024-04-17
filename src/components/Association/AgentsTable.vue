<script>
import api from '@/stores/api'
import UserCreateModal from '@/components/Association/AgentsModal.vue'
import { useModalStore } from '@/stores/modal'
import { getCurrentInstance, watch } from 'vue'
export default {
  components: {
    UserCreateModal
  },
  setup() {
    const store = useModalStore()
    const instance = getCurrentInstance()
    const setModal = useModalStore().setModal
    const setData = useModalStore().setData
    const openModal = useModalStore().openModal
    watch(
      () => store.updated,
      () => {
        if (instance && instance.proxy) {
          instance.proxy.fetchdata()
        }
      }
    )
    return { setModal, setData, openModal }
  },
  data() {
    return {
      entity: 'association-agents',
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
  showModal() {
    this.setModal()
  },
  methods: {
    edit(id) {
      const data = this.packages.find((item) => item.id === id)
      console.log(data)
      this.setData(data)
      this.openModal()
    },
    showModal() {
      this.setModal()
    },
    fetchdata() {
      api.get(`/${this.entity}?&page=${this.page}`).then((response) => {
        // console.log(response.data.data)
        this.packages = response.data.data
        this.pages = response.data.last_page
      })
    },
    deleteItem(id) {
      api.delete(`/users/${id}`).then(() => {
        this.packages = this.packages.filter((item) => item.id !== id)
        this.fetchdata()
      })
    }
  },

  computed: {
    visiblePages() {
      let min = this.page - 1
      let max = this.page + 1

      min = Math.max(min, 1)
      max = Math.min(max, this.pages)
      if (max - min < 2) {
        if (min === 1) max = Math.min(3, this.pages)
        else if (max === this.pages) min = Math.max(1, this.pages - 2)
      }

      const range = []
      for (let i = min; i <= max; i++) {
        range.push(i)
      }
      return range
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
              nom
            </th>
            <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">Role</th>
            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">Ville</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in packages" :key="index">
            <td class="py-5 px-4 pl-9 xl:pl-11">
              <div class="flex items-center gap-3">
                <img class="h-11 w-11 rounded-full" :src="item.image" loading="lazy" />
                <div>
                  <h5 class="font-medium text-black dark:text-white">{{ item.name }}</h5>
                  <p class="text-sm">{{ item.email }}</p>
                </div>
              </div>
            </td>
            <td class="py-5 px-4">
              <p class="text-black dark:text-white">{{ item.position }}</p>
            </td>
            <td class="py-5 px-4">
              <p class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium">
                {{ item.city }}
              </p>
            </td>
            <td class="py-5 px-4">
              <div class="flex items-center space-x-3.5">
                <button class="hover:text-primary">
                  <i class="bi bi-archive"></i>
                </button>
                <button @click="deleteItem(item.id)" class="hover:text-primary">
                  <svg
                    class="fill-current"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                      fill=""
                    />
                    <path
                      d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                      fill=""
                    />
                    <path
                      d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                      fill=""
                    />
                    <path
                      d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                      fill=""
                    />
                  </svg>
                </button>

                <button class="hover:text-primary" @click="edit(item.id)">
                  <i class="bi bi-pencil-square"></i>
                </button>
              </div>
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
        v-for="num in visiblePages"
        :key="num"
        @click="page = num"
        class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row"
        :class="{ 'opacity-50': page === num }"
      >
        <span class="text-black font-semibold dark:text-white">{{ num }}</span>
      </button>
      <button
        :disabled="page >= pages"
        @click="page++"
        class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row"
      >
        <span class="font-semibold text-black dark:text-white">»</span>
      </button>
    </div>
  </div>
  <button
    @click="showModal()"
    class="inline-flex mt-6 items-center justify-center gap-2.5 py-4 px-10 text-center font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-primary text-white"
  >
    Create
  </button>
  <UserCreateModal />
</template>
