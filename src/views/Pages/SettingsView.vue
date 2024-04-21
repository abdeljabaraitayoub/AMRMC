<script setup lang="ts">
import { ref } from 'vue'
import SettingsCard from '@/components/SettingsCard.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'

const pageTitle = ref('Settings Page')
</script>

<template>
  <DefaultLayout>
    <!-- ===== Content Area Start ===== -->

    <main>
      <SettingsCard />
    </main>
    <!-- ===== Main Content End ===== -->
  </DefaultLayout>
</template>
