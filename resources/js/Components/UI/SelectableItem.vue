<template>
  <div class="w-full cursor-pointer relative" :class="{ ' bg-teal-100/20': selected }">
    <Icon v-if="!selected" icon="fluent:circle-24-regular" class="absolute right-4 top-4 w-7 h-7 text-slate-400" />
    <Icon v-else icon="fluent:checkmark-circle-24-filled" class="absolute right-4 top-4 w-7 h-7 text-teal-500" />
    <slot></slot>
  </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";

const props = defineProps({
  selected: {
    type: Boolean,
    // required: true,
  },
});
</script>
