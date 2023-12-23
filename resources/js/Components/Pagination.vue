<template>
  <div class="flex text-[15px] gap-1 md:gap-2 items-center w-full justify-center">
    <Link
      v-for="(link, index) in links"
      :key="index"
      class="px-2 py-1 md:px-4 md:py-2 md:text-base border rounded-lg font-medium bg-slate-50"
      :href="link.url ?? ''"
      :class="{ 'bg-teal-500 text-slate-50 border-teal-500': link.active, 'text-slate-400': !link.url }"
      v-html="link.label"
    ></Link>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({ links: Array });
</script>
