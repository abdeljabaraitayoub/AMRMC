<script setup lang="ts">
import { RouterView } from 'vue-router'

import { useModalStore } from './stores/modal'
const modalStore = useModalStore().show
</script>

<template>
  <RouterView />
</template>
