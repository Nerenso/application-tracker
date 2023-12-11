<template>
  <AuthenticatedLayout>
    <Head title="Job Listings" />
    <div class="min-h-screen w-full">
      <nav class="w-full">
        <div class="max-w-5xl w-full mx-auto bg-blue-400 p-6 flex items-center justify-between">
          <div>LOGO</div>
          <XButton @click="openModal">Add Listing</XButton>
        </div>
      </nav>
      <section class="w-full">
        <div class="max-w-5xl w-full mx-auto">
          <h2>HELLO FROM JOB LISTING INDEX</h2>
          <div v-for="listing in listings" :key="listing.id">
            <h3 class="text-lg font-semibold">{{ listing.company_name }}</h3>
            <div class="flex items-center gap-4">
              <div v-for="tag in listing.tags" :key="tag.id">
                {{ tag.title }}
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <XModal v-model="showModal" backdrop>
      <template #image> </template>
      <template #header> New Job Opening </template>

      <form class="w-full h-[400px]">
        <XInput label="Job Link" class="w-full" id="job_link" v-model="listingForm.job_link" placeholder="https://google.com" />
        <h3>Tags</h3>
        <div class="flex items-center gap-x-2 gap-y-4 flex-wrap">
          <div v-for="tag in tags" :key="tag.id">
            <div
              v-if="!listingForm.selectedMultiple.includes(tag.id)"
              @click="addToSelected(tag.id)"
              class="px-2.5 text-xs py-1.5 rounded-full cursor-pointer font-semibold"
              :class="colorVariants[tag.color]"
            >
              <p>{{ tag.title }}</p>
            </div>
            <div
              v-if="listingForm.selectedMultiple.includes(tag.id)"
              @click="removeFromSelected(tag.id)"
              class="px-2.5 text-xs py-1.5 font-semibold cursor-pointer rounded-full text-white"
              :class="selectedColorVariants[tag.color]"
            >
              <p>{{ tag.title }}</p>
            </div>
          </div>
        </div>
        <p>{{ listingForm.errors.job_link }}</p>

        <!-- <ColorSelector class="z-50" /> -->
      </form>

      <template #actions>
        <div class="text-right space-x-4">
          <x-button @click="showModal = false">Cancel</x-button>
          <x-button color="primary" @click="submit">Add Listing</x-button>
        </div>
      </template>
    </XModal>
  </AuthenticatedLayout>
</template>

<script setup>
import ColorSelector from "@/Components/ColorSelector.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { XButton, XModal, XInput, XSelect } from "@indielayer/ui";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  listings: Array,
  tags: Array,
});

const colorVariants = {
  amber: "bg-amber-100/60 text-amber-400/60",
  indigo: "bg-indigo-100/60 text-indigo-700/60",
  violet: "bg-violet-100/60 text-violet-700/60",
  emerald: "bg-emerald-100/60 text-emerald-700/60",
  purple: "bg-purple-100/60 text-purple-700/60",
  blue: "bg-blue-100/60 text-blue-700/60",
  red: "bg-red-100/60 text-red-700/60",
  lime: "bg-lime-100/60 text-lime-700/60",
  teal: "bg-teal-100/60 text-teal-700/60",
  rose: "bg-rose-100/60 text-rose-700/60",
};

const selectedColorVariants = {
  amber: "bg-amber-600",
  indigo: "bg-indigo-600",
  violet: "bg-violet-600",
  emerald: "bg-emerald-600",
  purple: "bg-purple-600",
  blue: "bg-blue-600",
  red: "bg-red-600",
  lime: "bg-lime-600",
  teal: "bg-teal-600",
  rose: "bg-rose-600",
};

const listingForm = useForm({
  job_link: "",
  selectedMultiple: [],
});

const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
  listingForm.selectedMultiple = [];
};

const addToSelected = (item) => {
  const foundItem = listingForm.selectedMultiple.includes(item);
  if (!foundItem) {
    listingForm.selectedMultiple.push(item);
  }
};

const removeFromSelected = (item) => {
  const foundItem = listingForm.selectedMultiple.includes(item);
  if (foundItem) {
    const newArray = [...listingForm.selectedMultiple].filter((element) => element !== item);
    listingForm.selectedMultiple = newArray;
  }
};

const tagForm = useForm({
  title: "",
});

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.selectedMultiple = [];
  showModal.value = false;
};

const submit = () =>
  listingForm.post(route("job-listing.store"), {
    onSuccess: () => {
      resetForm();
    },
  });

const submitTagForm = () => tagForm.post(route("tag.store"));
</script>
