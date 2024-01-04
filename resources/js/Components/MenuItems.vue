<template>
  <div class="flex flex-col gap-2.5">
    <Link
      v-for="(link, index) in navLinks"
      :href="link.routeName ? route(link.routeName) : '#'"
      :key="index"
      class="flex items-center gap-2 p-2 -ml-2 hover:bg-slate-50 cursor-pointer text-[17px] rounded-md hover:border-l-4 transition-all border-lduration-150 hover:border-teal-500"
      :class="route().current() == link.routeName ? ' bg-slate-50 border-teal-500 border-l-4' : 'border-transparent'"
    >
      <Icon class="text-slate-500 w-5 h-5" :icon="link.icon" />
      <span class="flex-1">{{ link.label }}</span>
    </Link>
  </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";

const navLinks = [
  { icon: "fluent:window-apps-16-regular", label: "Overview", routeName: "" },
  { icon: "fluent:document-bullet-list-16-regular", label: "Job Listings", routeName: "job-listing.index" },
  { icon: "fluent:tag-16-regular", label: "Tags", routeName: "" },
  { icon: "fluent:chart-person-20-regular", label: "Profile", routeName: "account.edit" },
];
</script>
