<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <div>Resume Subpage</div>
  </ListingDetailLayout>
</template>

<script setup>
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
