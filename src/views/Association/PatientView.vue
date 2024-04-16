<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultAdminLayout.vue'
import UsersTable from '@/components/Association/PatientsTable.vue'
export default {
  components: {
    BreadcrumbDefault,
    DefaultLayout,
    UsersTable
  },
  data() {
    return {
      pageTitle: 'Patients'
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
