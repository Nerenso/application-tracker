<template>
  <DashboardLayout title="Your Job Listings">
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block">Add Listing</XButton>
      <div @click="openModal" class="w-9 md:hidden h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center">
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <Head title="Job Listings" />
    <div class="min-h-screen w-full">
      <section class="w-full p-2">
        <div class="max-w-5xl w-full mx-auto">
          <div class="my-4 grid grid-cols-1 gap-6">
            <JobListing v-for="listing in listings.data" :key="listing.id" :listing-info="listing" />
          </div>
          <div class="py-8">
            <Pagination v-if="listings.links.length > 3" :links="listings.links" />
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
            <div
              v-if="!tags.length"
              class="flex items-center justify-center p-6 border w-full text-sm text-slate-500 border-slate-300 border-dashed rounded-lg"
            >
              <p>You haven't added any tags yet, click on the 'plus' icon to add tags.</p>
            </div>
          </div>
          <div>
            <XTextarea
              :adjust-to-text="false"
              label="Notes"
              class="w-full"
              rows="3"
              placeholder="Add your notes about this listing here..."
              v-model="listingForm.notes"
            />
            <p class="form-error">{{ listingForm.errors.notes }}</p>
          </div>
          <div class="flex items-center gap-2 w-full">
            <section class="w-full">
              <XInput type="number" label="Min. Salary" placeholder="2.000" class="w-full" v-model="listingForm.salary_from" />
              <p class="form-error">{{ listingForm.errors.salary_from }}</p>
            </section>

            <section class="w-full">
              <XInput type="number" label="Max. Salary" placeholder="3.500" v-model="listingForm.salary_to" class="w-full" />
              <p class="form-error">{{ listingForm.errors.salary_to }}</p>
            </section>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <section>
              <XInput label="Contact Name" placeholder="John Doe" class="w-full" v-model="listingForm.contact_name" />
              <p class="form-error">{{ listingForm.errors.contact_name }}</p>
            </section>

            <section>
              <XInput label="Phone" placeholder="06-12345678" class="w-full" v-model="listingForm.contact_phone" />
              <p class="form-error">{{ listingForm.errors.contact_phone }}</p>
            </section>

            <section>
              <XInput label="E-mail" placeholder="john@google.com" class="w-full" v-model="listingForm.contact_email" />
              <p class="form-error">{{ listingForm.errors.contact_email }}</p>
            </section>
          </div>
        </form>
      </template>
      <template #action>
        <x-button :loading="loading" color="primary" @click="submit">Add Listing</x-button>
      </template>
    </BaseModal>
  </DashboardLayout>
</template>

<script setup>
import AddTagWidget from "@/Components/AddTagWidget.vue";
import BaseModal from "@/Components/BaseModal.vue";
import JobListing from "@/Components/JobListing.vue";
import Pagination from "@/Components/Pagination.vue";
import { Icon } from "@iconify/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { XButton, XInput, XTextarea } from "@indielayer/ui";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  listings: Object,
  tags: Array,
});

const colorVariants = {
  amber: "bg-amber-100/60 text-amber-700/60",
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
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
});

const showModal = ref(false);
const loading = ref(false);

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

const setLoading = () => {
  loading.value = !loading.value;
};

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.selectedMultiple = [];
  listingForm.notes = "";
  listingForm.salary_from = null;
  listingForm.salary_to = null;
  listingForm.contact_name = "";
  listingForm.contact_phone = "";
  listingForm.contact_email = "";
  showModal.value = false;
};

const submit = () => {
  listingForm.clearErrors();
  listingForm.post(route("job-listing.store"), {
    onStart: () => {
      setLoading();
    },
    onSuccess: () => {
      resetForm();
      setLoading();
    },
    onError: () => {
      setLoading();
    },
  });
};
</script>
