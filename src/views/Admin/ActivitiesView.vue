<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import ActivitiesTable from '@/components/admin/ActivitiesTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    ActivitiesTable
  },
  data() {
    return {
      pageTitle: 'Activities'
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <ActivitiesTable />
    </div>
  </DefaultLayout>
</template>
