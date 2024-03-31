<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import DiseaseTable from '@/components/admin/DiseaseTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    DiseaseTable
  },
  data() {
    return {
      pageTitle: 'Diseases'
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <DiseaseTable />
    </div>
  </DefaultLayout>
</template>
