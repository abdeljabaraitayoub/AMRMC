<script>
import api from '@/stores/api'
import { useModalStore } from '@/stores/modal'
import { getCurrentInstance, watch } from 'vue'
import EventModal from '@/components/admin/EventModal.vue'

export default {
  components: {
    EventModal
  },
  setup() {
    const store = useModalStore()
    const instance = getCurrentInstance()
    var updated = useModalStore().updated
    const setModal = useModalStore().setModal
    const setData = useModalStore().setData
    const openModal = useModalStore().openModal
    const setPackage = useModalStore().setPackage

    watch(
      () => store.updated,
      () => {
        if (instance && instance.proxy) {
          instance.proxy.fetchEvents()
        }
      }
    )
    return { setModal, setData, openModal, setPackage, updated }
  },
  data() {
    return {
      days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      currentDate: new Date(
        Date.UTC(new Date().getUTCFullYear(), new Date().getUTCMonth(), new Date().getUTCDate())
      ),
      eventsData: {}
    }
  },
  computed: {
    calendarDays() {
      const year = this.currentDate.getUTCFullYear()
      const month = this.currentDate.getUTCMonth()
      const daysInMonth = this.getDaysInMonth(year, month)
      const firstDayIndex = daysInMonth[0].getUTCDay()

      const prevMonthDays = this.getDaysInMonth(year, month - 1)
        .slice(-firstDayIndex)
        .map((day) => ({ date: day, prevMonth: true, nextMonth: false }))

      const currentMonthDays = daysInMonth.map((day) => ({
        date: day,
        prevMonth: false,
        nextMonth: false
      }))

      const nextMonthDaysCount = 42 - currentMonthDays.length - prevMonthDays.length
      const nextMonthDays = this.getDaysInMonth(year, month + 1)
        .slice(0, nextMonthDaysCount)
        .map((day) => ({ date: day, prevMonth: false, nextMonth: true }))

      const allDays = [...prevMonthDays, ...currentMonthDays, ...nextMonthDays]

      return allDays.map((day) => {
        const dayKey = day.date.toISOString().split('T')[0]
        const event = this.eventsData[dayKey]
        return {
          ...day,
          isToday: this.isToday(day.date),
          event
        }
      })
    }
  },
  methods: {
    formatDate(dayMonth, year) {
      const dateString = `${dayMonth} ${year}`

      const date = new Date(dateString)

      const formattedDate =
        date.getFullYear() +
        '-' +
        ('0' + (date.getMonth() + 1)).slice(-2) +
        '-' +
        ('0' + date.getDate()).slice(-2)

      return formattedDate
    },
    edit(id) {
      for (const key in this.eventsData) {
        if (this.eventsData[key].id === id) {
          this.eventsData[key].endDate = this.formatDate(this.eventsData[key].endDate, '2024')
          this.setData(this.eventsData[key])
          this.openModal()
          break
        }
      }
      this.openModal()
    },
    OpenModal(date) {
      this.openModal()
      date = date.toISOString().split('T')[0]
      this.setData({ date })
    },
    getDaysInMonth(year, month) {
      const date = new Date(Date.UTC(year, month, 1))
      const days = []
      while (date.getUTCMonth() === month) {
        days.push(new Date(date))
        date.setUTCDate(date.getUTCDate() + 1)
      }
      return days
    },
    isToday(date) {
      const today = new Date(
        Date.UTC(new Date().getUTCFullYear(), new Date().getUTCMonth(), new Date().getUTCDate())
      )
      return date.toISOString().split('T')[0] === today.toISOString().split('T')[0]
    },
    fetchEvents() {
      api
        .get('events')
        .then((response) => {
          this.eventsData = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    deleteItem(id) {
      api.delete(`events/${id}`).then(() => {
        this.fetchEvents()
      })
    }
  },
  mounted() {
    this.fetchEvents()
  }
}
</script>

<template>
  <div
    class="w-full max-w-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="grid grid-cols-7 rounded-t-sm bg-primary text-white">
      <template v-for="day in days" :key="day">
        <div
          class="flex h-15 items-center justify-center p-1 text-xs font-semibold sm:text-base xl:p-5 first:rounded-tl-sm last:rounded-tr-sm"
        >
          <span class="w-full h-full flex items-center justify-center">
            {{ day }}<span class="hidden lg:block"> day </span>
          </span>
        </div>
      </template>
    </div>

    <div class="grid grid-cols-7">
      <div
        v-for="(day, index) in calendarDays"
        :key="index"
        class="ease relative h-20 cursor-pointer border border-stroke p-2 transition duration-500 hover:bg-gray dark:border-strokedark dark:hover:bg-meta-4 md:h-25 md:p-6 xl:h-31"
      >
        <div
          @click="this.OpenModal(day.date)"
          class="mx-auto flex h-24 w-10 flex-col overflow-hidden sm:w-full md:h-40 md:w-20 lg:w-28 2xl:w-40"
        >
          <span class="font-medium text-black dark:text-white">{{ day.date.getDate() }}</span>

          <div v-if="day.event" class="group h-16 w-full flex-grow cursor-pointer py-1 md:h-30">
            <span class="group-hover:text-primary md:hidden"> More </span>
            <div
              class="event invisible absolute left-2 z-99 mb-1 flex w-[90%] flex-col rounded-sm border-l-[3px] border-primary bg-gray px-3 py-1 text-left opacity-0 group-hover:visible group-hover:opacity-100 dark:bg-meta-4 md:visible md:opacity-100"
            >
              <span
                @click="edit(day.event.id)"
                class="event-name text-sm font-semibold text-black dark:text-white"
              >
                {{ day.event.title }}
              </span>
              <div @click="edit(day.event.id)" class="flex">
                <span class="time text-sm font-medium text-black dark:text-white">
                  {{ day.event.startDate }} - {{ day.event.endDate }}
                </span>
                <span @click.stop="deleteItem(day.event.id)" class="ml-auto opacity-65">
                  <i class="bi bi-trash"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <EventModal />
</template>
