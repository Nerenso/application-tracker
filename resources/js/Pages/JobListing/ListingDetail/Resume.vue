<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <section class="w-full px-2">
      <div class="mx-auto w-full max-w-5xl">
        <div>Resume Subpage</div>
      </div>
    </section>
  </ListingDetailLayout>
</template>

<script setup>
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});
</script>
