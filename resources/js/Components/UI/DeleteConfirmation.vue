<template>
  <BaseModal
    :title="title"
    :show-modal="showModal"
    button-color="danger"
    button-text="Delete"
  >
    <template #content>
      <slot />
    </template>
  </BaseModal>
</template>

<script setup>
import BaseModal from "./BaseModal.vue";

const props = defineProps({
  title: String,
  showModal: Boolean,
});
</script>
