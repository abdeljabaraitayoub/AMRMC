<script>
import { ref } from 'vue'
import ProfileCard from '@/components/ProfileCard.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
// import SidebarArea from '@/components/Sidebar/SidebarArea.vue'
export default {
  components: {
    ProfileCard,
    DefaultLayout
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
  <DefaultLayout>
    <!-- ===== Content Area Start ===== -->
    <!-- ===== Main Content Start ===== -->
    <main>
      <ProfileCard />
    </main>
  </DefaultLayout>
</template>
