<template>
  <div class="flex gap-2">
    <article
      v-for="option in testOptions"
      :key="option.value"
      class="flex items-center gap-1 rounded-lg border px-2 py-1"
    >
      <Icon icon="ic:outline-radio-button-unchecked" class="size-4" />
      <p>{{ option.label }}</p>
    </article>
  </div>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { ref } from "vue";

const props = defineProps({
  options: Array,
});

const testOptions = [
  { value: "note", label: "Note" },
  { value: "call_summary", label: "Call Summary" },
];

const selectedOption = ref(testOptions[0].value);
</script>
