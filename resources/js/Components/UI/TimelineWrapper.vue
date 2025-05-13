<template>
  <component
    :is="as"
    class="relative ml-1.5 mt-6 space-y-6 before:absolute before:-ml-px before:h-full before:w-0.5 before:rounded-full before:bg-gray-200 dark:before:bg-gray-700"
  >
    <slot></slot>
  </component>
</template>

<script setup>
const props = defineProps({
  as: {
    type: String,
    default: "div",
  },
});
</script>
