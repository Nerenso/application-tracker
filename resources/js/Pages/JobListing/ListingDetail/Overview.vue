<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ListingInfoBlock :listing="listing" />
  </ListingDetailLayout>
</template>

<script setup>
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";
import ListingInfoBlock from "@/Components/JobListing/ListingInfoBlock.vue";
import ListingDetail from "../ListingDetail.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
