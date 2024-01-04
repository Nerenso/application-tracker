<template>
  <div v-if="tags" v-for="tag in tags" :key="tag.id" class="px-2 text-[11px] py-1 rounded-md font-semibold" :class="colorVariants[tag.color]">
    {{ tag.title }}
  </div>
</template>

<script setup>
const props = defineProps({
  tags: Array,
});

const colorVariants = {
  amber: "bg-amber-100/60 text-amber-700/60",
  indigo: "bg-indigo-100/60 text-indigo-700/60",
  violet: "bg-violet-100/60 text-violet-700/60",
  emerald: "bg-emerald-100/60 text-emerald-700/60",
  purple: "bg-purple-100/60 text-purple-700/60",
  blue: "bg-blue-100/60 text-blue-700/60",
  red: "bg-red-100/60 text-red-700/60",
  lime: "bg-lime-100/60 text-lime-700/60",
  teal: "bg-teal-100/60 text-teal-700/60",
  rose: "bg-rose-100/60 text-rose-700/60",
};
</script>
