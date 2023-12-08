<template>
  <AuthenticatedLayout>
    <Head title="Job Listings" />
    <div class="min-h-screen w-full">
      <nav class="w-full">
        <div class="max-w-5xl w-full mx-auto bg-blue-400 p-6 flex items-center justify-between">
          <div>LOGO</div>
          <XButton @click="showModal = true">Add Listing</XButton>
        </div>
      </nav>
      <section class="w-full">
        <div class="max-w-5xl w-full mx-auto">
          <h2>HELLO FROM JOB LISTING INDEX</h2>
          <div v-for="listing in listings" :key="listing.id">
            <p>{{ listing.company_name }}</p>
          </div>
        </div>
      </section>
    </div>

    <XModal v-model="showModal" backdrop>
      <template #image> </template>
      <template #header> New Job Opening </template>

      <form class="w-full">
        <XInput label="Job Link" class="w-full" id="job_link" v-model="listingForm.job_link" placeholder="https://google.com" />
        <p>{{ listingForm.errors.job_link }}</p>
      </form>

      <template #actions>
        <div class="text-right space-x-4">
          <x-button @click="showModal = false">Cancel</x-button>
          <x-button @click="resetForm">Reset</x-button>
          <x-button color="success" @click="submit">Add Listing</x-button>
        </div>
      </template>
    </XModal>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { XButton, XModal, XInput } from "@indielayer/ui";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  listings: Array,
});

const showModal = ref(false);

const listingForm = useForm({
  job_link: "",
});

const resetForm = () => {
  listingForm.job_link = "";
  showModal.value = false;
};

const submit = () =>
  listingForm.post(route("job-listing.store"), {
    onSuccess: () => {
      resetForm();
    },
  });
</script>
