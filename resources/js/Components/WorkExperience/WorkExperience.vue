<template>
  <ContentBox>
    <article class="p-6 flex flex-col gap-4">
      <h4>{{ workExperience.job_title }}</h4>
      <div v-html="workExperience.job_description"></div>
    </article>
  </ContentBox>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
const props = defineProps({
  workExperience: Object,
});
</script>
