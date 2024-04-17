<script>
import api from '@/stores/api'
import { useModalStore } from '@/stores/modal'

export default {
  setup() {
    const modalStore = useModalStore()

    function closeModal() {
      modalStore.setModal()
    }
    return { modalStore, closeModal }
  },
  data() {
    return {
      entity: 'diseases',
      data: {}
    }
  },
  methods: {
    createorupdate() {
      if (this.modalStore.data.id) {
        this.update()
      } else {
        this.create()
      }
    },
    create() {
      api
        .post(this.entity, this.modalStore.data)
        .then((response) => {
          this.closeModal()
          this.modalStore.setUpdate()
        })
        .catch((error) => {
          console.error(error)
        })
    },
    update() {
      api
        .put(`${this.entity}/${this.modalStore.data.id}`, this.modalStore.data)
        .then((response) => {
          this.closeModal()
          this.modalStore.setUpdate()
        })
        .catch((error) => {
          console.error(error)
        })
    }
  }
}
</script>

<template>
  <div class="mt-6">
    <div
      v-if="modalStore.show"
      class="overflow-y-auto fixed inset-0 justify-center items-center flex backdrop-blur-sm"
      style="z-index: 999"
    >
      <div class="my-auto mx-auto w-2/4">
        <!--content-->
        <div
          class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
        >
          <!--header-->
          <div
            class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t"
          >
            <h2 class="text-title-md2 font-semibold text-black dark:text-white">Create</h2>
            <button class="hover:text-primary" v-on:click="closeModal()">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <!--body-->
          <form>
            <!-- Full Name Section -->
            <div class="my-5.5 flex flex-col gap-5.5 sm:flex-row">
              <div class="w-full">
                <label
                  class="mb-3 block text-sm font-medium text-black dark:text-white"
                  for="fullName"
                >
                  Name</label
                >
                <div class="relative">
                  <span class="absolute left-4.5 top-4"><i class="bi bi-bandaid"></i> </span
                  ><input
                    v-model="modalStore.data.name"
                    class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                    type="text"
                    name="fullName"
                    id="fullName"
                    placeholder="Diabetes"
                  />
                </div>
              </div>
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >symptoms</label
              ><input
                v-model="modalStore.data.symptoms"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="extreme hunger"
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >causes</label
              >
              <input
                v-model="modalStore.data.causes"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                name="Username"
                id="Username"
                placeholder="Genetic factors"
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >treatment</label
              >
              <input
                v-model="modalStore.data.treatment"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                name="Username"
                id="Username"
                placeholder="diet"
              />
            </div>
            <!-- Bio Section -->
            <div class="mb-5.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="bio"
                >description</label
              >
              <div class="relative">
                <span class="absolute left-4.5 top-4"
                  ><svg
                    class="fill-current"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g opacity="0.8" clip-path="url(#clip0_88_10224)">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M1.56524 3.23223C2.03408 2.76339 2.66997 2.5 3.33301 2.5H9.16634C9.62658 2.5 9.99967 2.8731 9.99967 3.33333C9.99967 3.79357 9.62658 4.16667 9.16634 4.16667H3.33301C3.11199 4.16667 2.90003 4.25446 2.74375 4.41074C2.58747 4.56702 2.49967 4.77899 2.49967 5V16.6667C2.49967 16.8877 2.58747 17.0996 2.74375 17.2559C2.90003 17.4122 3.11199 17.5 3.33301 17.5H14.9997C15.2207 17.5 15.4326 17.4122 15.5889 17.2559C15.7452 17.0996 15.833 16.8877 15.833 16.6667V10.8333C15.833 10.3731 16.2061 10 16.6663 10C17.1266 10 17.4997 10.3731 17.4997 10.8333V16.6667C17.4997 17.3297 17.2363 17.9656 16.7674 18.4344C16.2986 18.9033 15.6627 19.1667 14.9997 19.1667H3.33301C2.66997 19.1667 2.03408 18.9033 1.56524 18.4344C1.0964 17.9656 0.833008 17.3297 0.833008 16.6667V5C0.833008 4.33696 1.0964 3.70107 1.56524 3.23223Z"
                        fill=""
                      ></path>
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M16.6664 2.39884C16.4185 2.39884 16.1809 2.49729 16.0056 2.67253L8.25216 10.426L7.81167 12.188L9.57365 11.7475L17.3271 3.99402C17.5023 3.81878 17.6008 3.5811 17.6008 3.33328C17.6008 3.08545 17.5023 2.84777 17.3271 2.67253C17.1519 2.49729 16.9142 2.39884 16.6664 2.39884ZM14.8271 1.49402C15.3149 1.00622 15.9765 0.732178 16.6664 0.732178C17.3562 0.732178 18.0178 1.00622 18.5056 1.49402C18.9934 1.98182 19.2675 2.64342 19.2675 3.33328C19.2675 4.02313 18.9934 4.68473 18.5056 5.17253L10.5889 13.0892C10.4821 13.196 10.3483 13.2718 10.2018 13.3084L6.86847 14.1417C6.58449 14.2127 6.28409 14.1295 6.0771 13.9225C5.87012 13.7156 5.78691 13.4151 5.85791 13.1312L6.69124 9.79783C6.72787 9.65131 6.80364 9.51749 6.91044 9.41069L14.8271 1.49402Z"
                        fill=""
                      ></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_88_10224">
                        <rect width="20" height="20" fill="white"></rect>
                      </clipPath>
                    </defs></svg></span
                ><textarea
                  v-model="modalStore.data.description"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  name="bio"
                  id="bio"
                  rows="3"
                  placeholder="Write a description here..."
                ></textarea>
              </div>
            </div>
          </form>
          <!--footer-->
          <div class="flex items-center justify-end my-3">
            <button
              class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white mr-3"
              type="button"
              v-on:click="closeModal()"
            >
              Cancel</button
            ><button
              class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
              type="submit"
              v-on:click="createorupdate()"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
  </div>
</template>
