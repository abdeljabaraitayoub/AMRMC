<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import UsersTable from '@/components/admin/AssociationTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    UsersTable
  },
  data() {
    return {
      pageTitle: 'associations'
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <div class="mx-auto max-w-7xl">
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <UsersTable />
    </div>
  </DefaultLayout>
</template>
