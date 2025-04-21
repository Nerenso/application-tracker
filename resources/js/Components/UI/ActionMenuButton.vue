<template>
  <button
    class="flex w-full items-center justify-start gap-1 rounded-md p-2 transition-all duration-150 hover:bg-slate-50"
  >
    <Icon :icon="iconName" class="h-5 w-5 p-[1.5px]" />
    <span>{{ buttonText }}</span>
  </button>
</template>

<script setup>
import { Icon } from "@iconify/vue";

const props = defineProps({
  iconName: {
    type: String,
    required: true,
  },
  buttonText: {
    type: String,
    required: true,
  },
});
</script>
