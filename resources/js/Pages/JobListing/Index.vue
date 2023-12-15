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
          <div v-for="listing in listings" :key="listing.id" class="my-4">
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

    <BaseModal @close="closeModal" :show-modal="showModal" title="Add New Job Listing">
      <template #content>
        <form class="w-full space-y-4">
          <XInput label="Job Link" class="w-full" id="job_link" v-model="listingForm.job_link" placeholder="https://google.com" :required="true" />
          <p class="form-error">{{ listingForm.errors.job_link }}</p>
          <div class="my-4 flex items-center justify-between w-full">
            <label class="font-medium">Tags</label>
            <AddTagWidget class="z-50" />
          </div>
          <div class="flex items-center gap-x-1.5 gap-y-2 flex-wrap">
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
          <div>
            <XTextarea :adjust-to-text="false" label="Notes" class="w-full" rows="3" placeholder="Add your notes about this listing here..." />
          </div>
          <div class="flex items-center gap-2 w-full">
            <XInput type="number" label="Salary From" placeholder="2.000" class="w-full" />
            <XInput type="number" label="Salary To" placeholder="3.500" class="w-full" />
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <XInput label="Contact Name" placeholder="John Doe" class="w-full" />
            <XInput label="Phone" placeholder="06-12345678" class="w-full" />
            <XInput label="E-mail" placeholder="john@google.com" class="w-full" />
          </div>
        </form>
      </template>
      <template #action>
        <x-button color="primary" @click="submit">Add Listing</x-button>
      </template>
    </BaseModal>
  </AuthenticatedLayout>
</template>

<script setup>
import AddTagWidget from "@/Components/AddTagWidget.vue";
import BaseModal from "@/Components/BaseModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { XButton, XInput, XTextarea } from "@indielayer/ui";
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

const closeModal = () => {
  showModal.value = false;
};

const openModal = () => {
  showModal.value = true;
  listingForm.selectedMultiple = [];
  listingForm.clearErrors();
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
</script>
