<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <div>Cover Letter Subpage</div>
  </ListingDetailLayout>
</template>

<script setup>
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";
const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
