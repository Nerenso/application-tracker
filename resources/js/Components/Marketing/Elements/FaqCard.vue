<template>
  <div class="w-full rounded-xl border p-4 md:p-6">
    <h6 class="text-lg font-medium">{{ question }}</h6>
    <p class="mt-4 text-slate-700">{{ answer }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  question: String,
  answer: String,
});
</script>
