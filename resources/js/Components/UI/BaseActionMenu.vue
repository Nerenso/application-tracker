<template>
  <article class="relative h-8">
    <div
      v-if="isOpen"
      @click.stop="setIsOpen(false)"
      class="fixed left-0 top-0 h-full w-full cursor-default"
    />
    <button @click.stop="setIsOpen(!isOpen)">
      <Icon
        class="h-8 w-8 rounded-lg p-1 transition-all duration-100 hover:bg-slate-50"
        icon="fluent:more-vertical-20-regular"
      />
    </button>

    <div
      ref="menuPanel"
      :style="{ minWidth: `${minWidth}px` }"
      class="absolute right-2 top-8 z-40 origin-top-right rounded-lg border bg-white p-2 shadow-lg transition-all duration-100"
      :class="[
        isOpen
          ? 'visible translate-y-0 scale-100 opacity-100'
          : 'invisible -translate-y-4 scale-90 opacity-0',
      ]"
    >
      <slot></slot>
    </div>
  </article>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { ref } from "vue";

const props = defineProps({
  minWidth: {
    type: Number,
    default: 180,
    required: true,
  },
  isOpen: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:isOpen"]);

const menuPanel = ref(null);

const setIsOpen = (newVal) => {
  emit("update:isOpen", newVal);
};
</script>
