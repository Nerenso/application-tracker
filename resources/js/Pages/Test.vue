<template>
  <main class="flex items-center justify-center min-h-screen w-full bg-slate-50">
    <div class="rounded-2xl p-6 shadow-md bg-white max-w-screen-sm w-full space-y-6">
      <h4>Hello from Test</h4>
      <p>{{ message }}</p>

      <!-- <div v-if="company_name">{{ company_name }}</div> -->
      <div v-if="coverLetter" class="whitespace-pre-line" v-html="coverLetter"></div>
      <div v-else>
        <XSpinner />
      </div>
      <XInput type="number" label="Listing ID" class="w-full" v-model="listingIdInput" />
      <XButton @click="handleCheck" color="primary">Check</XButton>
    </div>
  </main>
</template>

<script setup>
import { XButton, XInput, XSpinner } from "@indielayer/ui";
import { router } from "@inertiajs/vue3";
import { onBeforeUnmount } from "vue";
import { onMounted } from "vue";
import { ref } from "vue";
const props = defineProps({
  message: String,
  jobListing: Object,
});

const listingIdInput = ref("");
const company_name = ref("");
const coverLetter = ref("");

let echoChannel;

const handleCheck = () => {
  company_name.value = null;
  router.visit(route("test", { listingId: listingIdInput.value }));
};

onMounted(() => {
  echoChannel = Echo.private("test-job");

  echoChannel.listen("TestJobFinished", (e) => {
    console.log(e);
    company_name.value = e.company_name;
    coverLetter.value = e.cover_letter;
  });
});

onBeforeUnmount(() => {
  echoChannel.stopListening("TestJobFinished");
});
</script>
