<script>
import { ref } from 'vue'
import ProfileCard from '@/components/ProfileCard.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import HeaderArea from '@/components/Header/HeaderArea.vue'
// import SidebarArea from '@/components/Sidebar/SidebarArea.vue'
export default {
  components: {
    ProfileCard,
    DefaultLayout,
    HeaderArea
  },
  mounted() {},
  data() {
    return {
      pageTitle: 'Profile',
      profile: {}
    }
  },
  methods: {}
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const pageTitle = ref('Profile')
</script>

<template>
  <DefaultLayout v-show="false"> </DefaultLayout>
  <!-- ===== Content Area Start ===== -->
  <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
    <!-- ===== Header Start ===== -->
    <HeaderArea />
    <!-- ===== Header End ===== -->

    <!-- ===== Main Content Start ===== -->
    <main>
      <div class="mx-auto max-w-screen-2xl py-10">
        <div class="mx-auto">
          <ProfileCard />
        </div>
      </div>
    </main>
    <!-- ===== Main Content End ===== -->
  </div>
</template>
