<template>
  <DashboardLayout title="Education">
    <Head title="Education" />
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block">Add Education</XButton>
      <div @click="showModal = true" class="w-9 md:hidden h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center">
        <Icon icon="mi:add" class="" />
      </div>
    </template>

    <div class="min-h-screen w-full">
      <section v-if="!education?.length" class="w-full p-2">
        <EmptyState>
          <div class="flex flex-col gap-4 mb-4">
            <p class="empty-state-text">You haven't added any education yet. Try adding some.</p>
            <XButton class="w-fit mx-auto" color="primary" @click="openModal">Add New Education</XButton>
          </div>
        </EmptyState>
      </section>

      <section v-else class="w-full p-2 md:p-6">
        <div class="max-w-5xl w-full mx-auto">
          <div class="my-4 grid grid-cols-1 gap-4">
            <EducationCard v-for="edu in education" :key="edu.id" :education="edu" />
          </div>
        </div>
      </section>
    </div>

    <EducationForm
      modal-title="Add New Education"
      modal-type="New"
      :show-modal="showModal"
      @modalClosed="showModal = false"
      success-button-text="Add Education"
    />
  </DashboardLayout>
</template>

<script setup>
import EducationCard from "@/Components/Education/EducationCard.vue";
import EducationForm from "@/Components/Education/EducationForm.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Icon } from "@iconify/vue";
import { XButton } from "@indielayer/ui";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  education: Object,
});

const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
};
</script>
