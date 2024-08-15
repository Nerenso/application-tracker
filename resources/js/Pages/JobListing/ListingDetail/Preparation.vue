<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ContentBox class="w-full max-w-5xl mx-auto p-4 sm:p-6">
      <header class=""><h4>Preparation</h4></header>
      <main class="">
        <LoadingGraphic v-if="isGenerating">
          <template #title> Generating Questions! </template>
          <template #subtitle> It will be ready shortly. </template>
        </LoadingGraphic>
        <EmptyState v-if="!localPreparationObject && !isGenerating">
          <div class="flex flex-col gap-4 mb-4">
            <p class="empty-state-text">
              Let us help come up with some questions you can ask the employer to show your interest in their company and job opening.
            </p>
            <XButton @click="generateQuestions" class="w-fit mx-auto" color="primary">Generate Questions</XButton>
          </div>
        </EmptyState>
        <div v-if="localPreparationObject && !isGenerating" class="mt-4">
          <section class="space-y-4 sm:space-y-0 sm:grid grid-cols-3 sm:gap-4 mb-6">
            <div class="">
              <p class="helper-text-sm">Contact Name</p>
              <p class="font-medium text-lg">{{ listing.contact_name ?? "-" }}</p>
            </div>
            <div class="">
              <p class="helper-text-sm">Email</p>
              <a v-if="listing.contact_email" :href="`mailto:${listing.contact_email}`">
                <p class="font-medium text-lg">{{ listing.contact_email }}</p>
              </a>
              <p v-else class="font-medium text-lg">-</p>
            </div>
            <div class="">
              <p class="helper-text-sm">Phone</p>
              <a v-if="listing.contact_phone" :href="`tel:${listing.contact_phone}`">
                <p class="font-medium text-lg">{{ listing.contact_phone }}</p>
              </a>
              <p v-else class="font-medium text-lg">-</p>
            </div>
          </section>

          <section class="space-y-4 mb-6">
            <h4>Questions</h4>
            <div class="space-y-4 sm:space-y-4">
              <article v-for="(question, index) in questionsArray" :key="index">
                <p class="p-3 sm:p-4 text-[17px] font-base border rounded-lg">{{ question }}</p>
              </article>
            </div>
          </section>
          <section>
            <XTextarea
              label="Notes"
              rows="6"
              class="w-full"
              :adjust-to-text="false"
              placeholder="Write your preparation notes here..."
              v-model="preparationNotes"
            />
          </section>
        </div>
      </main>
    </ContentBox>
  </ListingDetailLayout>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import { XButton, XTextarea } from "@indielayer/ui";
import { ref } from "vue";
import LoadingGraphic from "@/Components/UI/LoadingGraphic.vue";
import { onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { watch } from "vue";
import { onBeforeUnmount } from "vue";

const props = defineProps({
  listing: Object,
  tags: Array,
  preparation: Object,
});

const localPreparationObject = ref(null);
const preparationNotes = ref("");
const questionsArray = ref(null);
const isGenerating = ref(false);

let echoChannel;

onMounted(() => {
  if (props.preparation) {
    localPreparationObject.value = props.preparation;
    preparationNotes.value = props.preparation.notes;
    questionsArray.value = JSON.parse(localPreparationObject.value.suggested_questions).questions;
  }
});

onBeforeUnmount(() => {
  if (props.preparation && props.preparation.notes !== preparationNotes.value) {
    router.patch(route("preparation.update", props.preparation.id), {
      listingId: props.listing.id,
      notes: preparationNotes.value,
    });
  }
});

watch(localPreparationObject, (newVal, oldVal) => {
  if (newVal !== oldVal && echoChannel) {
    echoChannel.stopListening("PreparationQuestionsGenerationFinished");
  }
});

const startGeneration = () => {
  isGenerating.value = true;
  echoChannel = Echo.private(`job-listings.${props.listing.id}.preparation-questions`);

  echoChannel.listen("PreparationQuestionsGenerationFinished", (e) => {
    localPreparationObject.value = e.preparation;
    questionsArray.value = JSON.parse(localPreparationObject.value.suggested_questions).questions;
    isGenerating.value = false;
  });
};

const generateQuestions = () => {
  startGeneration();
  router.post(
    route("preparation.store", props.listing.id),
    {
      listingId: props.listing.id,
    },
    {
      preserveScroll: true,
    }
  );
};
</script>
