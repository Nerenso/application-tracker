<template>
  <img v-if="mode === 'light'" src="/images/jobdeck-alt0.2.svg" />
  <img v-else src="/images/jobdeck-alt-dark.svg" />
</template>

<script setup>
const props = defineProps({
  mode: {
    type: String,
    default: "light",
  },
});
</script>
