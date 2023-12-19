<template>
  <div class="flex gap-2 items-center w-full justify-center">
    <Link
      v-for="(link, index) in links"
      :key="link.index"
      class="px-4 py-2 border rounded-lg font-medium bg-slate-50"
      :href="link.url"
      :class="{ 'bg-teal-500 text-slate-50 border-teal-500': link.active }"
      v-html="link.label"
    ></Link>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({ links: Array });
</script>
