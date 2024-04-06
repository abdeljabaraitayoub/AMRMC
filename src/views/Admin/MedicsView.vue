<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import MedicsTable from '@/components/admin/MedicsTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    MedicsTable
  },
  data() {
    return {
      pageTitle: 'Medics'
    }
  }
}
</script>
<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <MedicsTable />
    </div>
  </DefaultLayout>
</template>
