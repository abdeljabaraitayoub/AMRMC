<script>
import api from '@/stores/api'
export default {
  data() {
    return {
      cardItems: [
        {
          icon: `<i class="bi bi-person-fill"></i>`,
          title: 'Total Users'
        },
        {
          icon: `<i class="bi bi-people-fill"></i>`,
          title: 'Total associations'
        },
        {
          icon: `<i class="bi bi-virus"></i>`,
          title: 'Total Diseases'
        },
        {
          icon: `<i class="bi bi-capsule"></i>`,
          title: 'Total Admins'
        }
      ]
    }
  },
  methods: {
    fetchData() {
      api.get('stats').then((response) => {
        this.cardItems[0].total = response.data.users
        this.cardItems[0].growthRate = response.data.userGrowthRate
        this.cardItems[1].total = response.data.associations
        this.cardItems[1].growthRate = response.data.associationGrowthRate
        this.cardItems[2].total = response.data.diseases
        this.cardItems[2].growthRate = response.data.diseaseGrowthRate
        this.cardItems[3].total = response.data.medics
        this.cardItems[3].growthRate = response.data.medicsGrowthRate
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
    v-for="(item, index) in cardItems"
    :key="index"
    class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div
      class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
      v-html="item.icon"
    ></div>

    <div class="mt-4 flex items-end justify-between">
      <div>
        <h4 class="text-title-md font-bold text-black dark:text-white">{{ item.total }}</h4>
        <span class="text-sm font-medium">{{ item.title }}</span>
      </div>
      <span
        class="flex items-center gap-1 text-sm font-medium"
        :class="{ 'text-meta-3': item.growthRate > 0, 'text-meta-5': item.growthRate < 0 }"
      >
        {{ item.growthRate }}%
        <svg
          v-if="item.growthRate > 0"
          class="fill-meta-3"
          width="10"
          height="11"
          viewBox="0 0 10 11"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z"
            fill=""
          />
        </svg>

        <svg
          v-if="item.growthRate < 0"
          class="fill-meta-5"
          width="10"
          height="11"
          viewBox="0 0 10 11"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M5.64284 7.69237L9.09102 4.33987L10 5.22362L5 10.0849L-8.98488e-07 5.22362L0.908973 4.33987L4.35716 7.69237L4.35716 0.0848701L5.64284 0.0848704L5.64284 7.69237Z"
            fill=""
          />
        </svg>
      </span>
    </div>
  </div>
</template>
