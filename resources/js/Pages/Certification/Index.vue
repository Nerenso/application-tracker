<template>
  <DashboardLayout title="Certifications">
    <Head title="Certifications" />
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block">Add Certification</XButton>
      <div @click="openModal" class="w-9 md:hidden h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center">
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <div class="min-h-screen w-full">
      <section v-if="!certifications?.length" class="w-full p-2">
        <EmptyState>
          <div class="flex flex-col gap-4 mb-4">
            <p class="empty-state-text">You haven't added any certifications yet. Try adding some.</p>
            <XButton class="w-fit mx-auto" color="primary" @click="openModal">Add New Certification</XButton>
          </div>
        </EmptyState>
      </section>

      <section v-else class="w-full p-2 md:p-6">
        <div class="max-w-5xl w-full mx-auto">
          <div class="my-4 grid grid-cols-1 gap-4">
            <CertificationCard v-for="cert in certifications" :key="cert.id" :certification="cert" />
          </div>
        </div>
      </section>
    </div>
    <CertificationForm
      modal-type="New"
      :show-modal="showModal"
      @close="showModal = false"
      modal-title="Add New Certification"
      success-button="Add Certification"
    />
  </DashboardLayout>
</template>

<script setup>
import CertificationCard from "@/Components/Certification/CertificationCard.vue";
import CertificationForm from "@/Components/Certification/CertificationForm.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Icon } from "@iconify/vue";
import { XButton } from "@indielayer/ui";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const showModal = ref(false);

const props = defineProps({
  certifications: Object,
});

const openModal = () => {
  showModal.value = true;
};
</script>
