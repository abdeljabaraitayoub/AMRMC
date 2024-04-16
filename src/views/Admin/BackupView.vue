<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import BackupCards from '@/components/admin/BackupCards.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    BackupCards
  },
  data() {
    return {
      pageTitle: 'Backup Management'
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <BackupCards />
    </div>
  </DefaultLayout>
</template>
