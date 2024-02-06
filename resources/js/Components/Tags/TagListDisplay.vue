<template>
  <section class="flex items-center gap-2">
    <div v-if="tags" v-for="tag in tags" :key="tag.id" class="px-2 text-[11px] py-1 rounded-md font-semibold" :class="colorVariants[tag.color]">
      {{ tag.title }}
    </div>
  </section>
</template>

<script setup>
import { colorVariants } from "@/Utils/TagColors";
const props = defineProps({
  tags: Array,
});
</script>
