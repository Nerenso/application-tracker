<template>
  <ListingDetail :listing="listing" :tags="tags">
    <div>Preparation Subpage</div>
  </ListingDetail>
</template>

<script setup>
import ListingDetail from "../ListingDetail.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
