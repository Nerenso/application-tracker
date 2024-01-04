<template>
  <label>
    <div class="flex items-center mb-1">
      <span class="font-medium">{{ label }}</span>
      <span v-if="isRequired" class="text-red-500 font-medium ml-0.5">*</span>
    </div>
    <slot></slot>
  </label>
</template>

<script setup>
const props = defineProps({
  label: String,
  isRequired: Boolean,
});
</script>
