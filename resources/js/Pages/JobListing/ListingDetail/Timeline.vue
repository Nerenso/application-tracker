<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ContentBox class="mx-auto w-full max-w-5xl p-4 sm:p-6">
      <h4>Activity Timeline</h4>
      <div class="mt-6">
        <UnderConstruction />
      </div>
    </ContentBox>
  </ListingDetailLayout>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import UnderConstruction from "@/Components/UI/UnderConstruction.vue";
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
