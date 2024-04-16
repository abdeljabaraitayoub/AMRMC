<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import UsersTable from '@/components/Association/AgentsTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    UsersTable
  },
  data() {
    return {
      pageTitle: 'Agents'
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
