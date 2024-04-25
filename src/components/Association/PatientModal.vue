<script>
import api from '@/stores/api'
import { useModalStore } from '@/stores/modal'
import Select2 from 'v-select2-component'

export default {
  components() {
    Select2
  },
  setup() {
    const modalStore = useModalStore()

    function openModal() {
      modalStore.setModal()
    }

    function closeModal() {
      modalStore.setModal()
    }
    return { modalStore, openModal, closeModal }
  },
  data() {
    return {
      entity: 'patients',
      data: {},
      diseases: [],
      image: null
    }
  },
  methods: {
    handleImageUpload(e, id) {
      this.image = e.target.files[0]
    },

    fetchdata() {
      api.get(`diseases?all=true`).then((response) => {
        this.diseases = response.data
      })
    },
    createorupdate() {
      if (this.modalStore.data.id) {
        this.update()
      } else {
        this.create()
      }
    },
    create() {
      const formdata = new FormData()
      formdata.append('img', this.image)

      api.post(this.entity, this.modalStore.data, {}).then((response) => {
        api
          .post(`image/${response.data.patient.id}`, formdata, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(() => {
            this.modalStore.setUpdate()
            this.closeModal()
          })
      })
    },
    update() {
      const formdata = new FormData()
      formdata.append('img', this.image)

      api
        .put(`${this.entity}/${this.modalStore.data.id}`, this.modalStore.data, {})
        .then((response) => {
          api
            .post(`image/${response.data.patient.id}`, formdata, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            })
            .then(() => {
              this.modalStore.setUpdate()
              this.closeModal()
            })
        })
    }
  },
  mounted() {
    this.fetchdata()
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
            <h2 class="text-title-md2 font-semibold text-black dark:text-white">Agent</h2>
            <button class="hover:text-primary" v-on:click="closeModal()">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <!--body-->
          <form>
            <!-- Full Name Section -->
            <div class="my-5.5 flex flex-col gap-5.5 sm:flex-row">
              <div class="w-full sm:w-1/2">
                <label
                  class="mb-3 block text-sm font-medium text-black dark:text-white"
                  for="fullName"
                >
                  Name</label
                >
                <div class="relative">
                  <span class="absolute left-4.5 top-4"><i class="bi bi-person"></i> </span
                  ><input
                    v-model="modalStore.data.name"
                    class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                    type="text"
                    name="fullName"
                    id="fullName"
                    placeholder="Jhon Doe"
                  />
                </div>
              </div>
              <div class="w-full sm:w-1/2">
                <label
                  class="mb-3 block text-sm font-medium text-black dark:text-white"
                  for="phoneNumber"
                  >phone number</label
                ><input
                  v-model="modalStore.data.phone"
                  class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="text"
                  name="phoneNumber"
                  id="phoneNumber"
                  placeholder="+212 123 456 7890"
                />
              </div>
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="emailAddress"
                >email</label
              >
              <div class="relative z-20 bg-white dark:bg-form-input">
                <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2"
                  ><i class="bi bi-envelope-at"></i>
                </span>
                <input
                  v-model="modalStore.data.email"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="text"
                  name="emailAddress"
                  id="emailAddress"
                  placeholder="jhondoe@gmail.com"
                />
              </div>
            </div>

            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >address</label
              ><input
                v-model="modalStore.data.address"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="13A Dama Road, Bauchi"
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >city</label
              ><input
                v-model="modalStore.data.city"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="13A Dama Road, Bauchi"
              />
            </div>
            <div class="mb-5.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Date"
                >Birth date</label
              ><input
                v-model="modalStore.data.date_of_birth"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="date"
                name="Date"
                id="Date"
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >medical record number</label
              ><input
                v-model="modalStore.data.medical_record_number"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="97632"
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >medical history</label
              ><input
                v-model="modalStore.data.medical_history"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="diabetes, hypertension, etc."
              />
            </div>
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="emailAddress"
                >disease</label
              >
              <div class="relative z-20 bg-white dark:bg-form-input">
                <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2"
                  ><i class="bi bi-bandaid-fill"></i></span
                ><select
                  v-model="modalStore.data.disease_id"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                >
                  <option disabled="">Select Country</option>
                  <option
                    v-for="disease in diseases"
                    :key="disease.id"
                    :value="disease.id"
                    class="text-body dark:text-bodydark"
                  >
                    {{ disease.name }}
                  </option>
                </select>
              </div>
            </div>
            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                image </label
              ><input
                @change="handleImageUpload"
                type="file"
                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
              />
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
