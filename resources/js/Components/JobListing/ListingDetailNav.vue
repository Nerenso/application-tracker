<template>
  <nav>
    <Link v-for="(link, index) in navListingLinks" :key="index" :href="route(link.routeName, listing.id)">{{ link.label }}</Link>
  </nav>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";

const navListingLinks = [
  // { icon: "fluent:window-apps-16-regular", label: "Overview", routeName: "" },
  { icon: "fluent:document-bullet-list-16-regular", label: "Overview", routeName: "listing-detail.overview" },
  { icon: "fluent:tag-16-regular", label: "Preparation", routeName: "listing-detail.preparation" },
];

const props = defineProps({
  listing: Object,
});
</script>
