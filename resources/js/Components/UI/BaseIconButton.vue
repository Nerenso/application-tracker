<template>
  <button @click.stop="emit('click')">
    <Icon
      class="h-8 w-8 rounded-lg p-1.5 transition-all duration-100 hover:bg-slate-50"
      :class="custom ? '' : 'text-slate-500'"
      :icon="icon"
    />
  </button>
</template>

<script setup>
import { Icon } from "@iconify/vue";

const props = defineProps({
  custom: {
    type: Boolean,
    default: false,
  },
  icon: String,
});

const emit = defineEmits(["click"]);
</script>
