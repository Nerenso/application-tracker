<template>
  <DashboardLayout title="Saved Listings" :show-top-bar="true">
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block"
        >Add Listing</XButton
      >
      <div
        @click="openModal"
        class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-500 text-white md:hidden"
      >
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <Head title="Saved Listings" />
    <div class="min-h-screen w-full">
      <section v-if="listings.data.length <= 0" class="w-full p-2">
        <EmptyState>
          <div class="mb-4 flex flex-col gap-4">
            <p class="empty-state-text">
              You haven't saved any job listings yet. Try adding a listing.
            </p>
            <XButton class="mx-auto w-fit" color="primary" @click="openModal"
              >Add New Listing</XButton
            >
          </div>
        </EmptyState>
      </section>
      <section v-else class="w-full p-2 md:p-6">
        <div class="mx-auto w-full max-w-5xl">
          <div class="my-4 grid grid-cols-1 gap-6">
            <JobListing
              v-for="listing in listings.data"
              :key="listing.id"
              :listing-info="listing"
              :tags="tags"
              @edit="openEditModal(listing)"
            />
          </div>
          <div v-if="listings.links.length > 3" class="space-y-4 py-8">
            <article class="mx-auto w-full text-center">
              <p class="text-sm font-medium">
                {{ getResultsInfo().startItemNumber }} -
                {{ getResultsInfo().lastItemNumber }}
                <span class="font-normal text-slate-600">out of</span>
                {{ getResultsInfo().total }}
                <span class="font-normal text-slate-600">listings</span>
              </p>
            </article>
            <Pagination :links="listings.links" />
          </div>
        </div>
      </section>
    </div>

    <BaseModal
      @close="closeModal"
      :show-modal="showModal"
      title="Add New Job Listing"
      button-text="Add Listing"
      @save="submit"
    >
      <template #content>
        <XTabGroup
          variant="block"
          v-model="listingForm.add_listing_mode"
          class="pb-4"
          grow
        >
          <XTab value="automated" label="AI Powered"></XTab>
          <XTab value="manual" label="Manual"></XTab>
        </XTabGroup>
        <form class="w-full space-y-4">
          <label
            v-if="listingForm.add_listing_mode === 'manual'"
            class="w-full"
          >
            <div class="mb-1 flex gap-0.5 font-medium">
              <p>Job Listing Text</p>
              <span class="text-red-500">*</span>
            </div>
            <div class="mb-4">
              <XTextarea
                :adjust-to-text="false"
                class="w-full"
                rows="4"
                placeholder="Paste the text of the job listing you found here."
                v-model="listingForm.pasted_listing_text"
              />
              <p
                v-if="listingForm.errors.pasted_listing_text"
                class="form-error"
              >
                {{ listingForm.errors.pasted_listing_text }}
              </p>
            </div>
          </label>

          <label>
            <div class="mb-1 flex gap-0.5 font-medium">
              <p>Job Link</p>
              <span class="text-red-500">*</span>
            </div>
            <XInput
              class="w-full"
              id="job_link"
              v-model="listingForm.job_link"
              placeholder="https://google.com"
              :required="true"
            />
            <p class="form-error">{{ listingForm.errors.job_link }}</p>
          </label>
          <div class="my-4 flex w-full items-center justify-between">
            <label class="font-medium">Tags</label>
            <AddTagWidget class="z-50" />
          </div>
          <div class="flex flex-wrap items-center gap-x-1.5 gap-y-2">
            <div v-for="tag in tags" :key="tag.id">
              <div
                v-if="!listingForm.selectedMultiple.includes(tag.id)"
                @click="addToSelected(tag.id)"
                class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold"
                :class="colorVariants[tag.color]"
              >
                <p>{{ tag.title }}</p>
              </div>
              <div
                v-if="listingForm.selectedMultiple.includes(tag.id)"
                @click="removeFromSelected(tag.id)"
                class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold text-white"
                :class="selectedColorVariants[tag.color]"
              >
                <p>{{ tag.title }}</p>
              </div>
            </div>
            <div
              v-if="!tags.length"
              class="flex w-full items-center justify-center rounded-lg border border-dashed border-slate-300 p-6 text-sm text-slate-500"
            >
              <p>
                You haven't added any tags yet, click on the 'plus' icon to add
                tags.
              </p>
            </div>
          </div>
          <div>
            <XTextarea
              :adjust-to-text="false"
              label="Notes"
              class="w-full"
              rows="4"
              placeholder="Add your notes about this listing here..."
              v-model="listingForm.notes"
            />
            <p class="form-error">{{ listingForm.errors.notes }}</p>
          </div>
          <div class="flex w-full items-center gap-2">
            <section class="w-full">
              <XInput
                type="number"
                label="Min. Salary"
                placeholder="2.000"
                class="w-full"
                v-model="listingForm.salary_from"
              />
              <p class="form-error">{{ listingForm.errors.salary_from }}</p>
            </section>

            <section class="w-full">
              <XInput
                type="number"
                label="Max. Salary"
                placeholder="3.500"
                v-model="listingForm.salary_to"
                class="w-full"
              />
              <p class="form-error">{{ listingForm.errors.salary_to }}</p>
            </section>
          </div>
          <div
            class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-2 lg:grid-cols-1"
          >
            <section>
              <XInput
                label="Location"
                placeholder="Amsterdam"
                class="w-full"
                v-model="listingForm.location"
              />
              <p class="form-error">{{ listingForm.errors.location }}</p>
            </section>
          </div>
        </form>
      </template>
    </BaseModal>

    <BaseNoticeModal
      :show-modal="showNotice"
      @dismissNotice="showNotice = false"
      button-text="Okay"
    >
      <template #content>
        <div class="flex justify-center">
          <dotlottie-player
            src="https://lottie.host/661a363f-4930-4f18-938a-0cb2319db0fc/N4ojeOuElV.json"
            background="transparent"
            speed="1"
            style="width: 300px; height: 230px"
            :autoplay.attr="true"
            :loop.attr="true"
          ></dotlottie-player>
        </div>
        <div class="mb-6 flex flex-col gap-4 text-center">
          <h3 class="">Email Verified</h3>
          <p class="pb-4 text-lg text-slate-600">
            You can now start using Jobdeck and enjoy a stressfree, streamlined
            job hunting experience.
          </p>
        </div>
      </template>
    </BaseNoticeModal>
  </DashboardLayout>
</template>

<script setup>
import EmptyState from "@/Components/UI/EmptyState.vue";
import AddTagWidget from "@/Components/Tags/AddTagWidget.vue";
import BaseModal from "@/Components/UI/BaseModal.vue";
import JobListing from "@/Components/JobListing/JobListing.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import { colorVariants, selectedColorVariants } from "@/Utils/TagColors";
import { Icon } from "@iconify/vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { XButton, XInput, XTab, XTabGroup, XTextarea } from "@indielayer/ui";
import { useForm, Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { onMounted } from "vue";
import BaseNoticeModal from "@/Components/UI/BaseNoticeModal.vue";

const props = defineProps({
  listings: Object,
  tags: Array,
  listings_paginator: Object,
  verified: String,
});

const showNotice = ref(false);
const showEditModal = ref(false);
const listingToEdit = ref(null);
const showModal = ref(false);
const loading = ref(false);

onMounted(() => {
  if (props.verified) {
    showNotice.value = true;
  }
});

const getResultsInfo = () => {
  let multiplier = props.listings_paginator.currentPage - 1;
  let itemCount = props.listings_paginator.count;
  let listingsPerPage = props.listings_paginator.listingsPerPage;
  let total = props.listings_paginator.total;

  let startItemNumber = listingsPerPage * multiplier + 1;
  let lastItemNumber = listingsPerPage * multiplier + itemCount;

  return { startItemNumber, lastItemNumber, total };
};

const openEditModal = (selectedListing) => {
  listingToEdit.value = selectedListing;
  showEditModal.value = true;
};

const listingForm = useForm({
  add_listing_mode: null,
  pasted_listing_text: "",
  job_link: "",
  selectedMultiple: [],
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
  location: "",
});

const closeModal = () => {
  showModal.value = false;
};

const openModal = () => {
  setTimeout(() => {
    listingForm.add_listing_mode = "automated";
  }, 0);
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
    const newArray = [...listingForm.selectedMultiple].filter(
      (element) => element !== item,
    );
    listingForm.selectedMultiple = newArray;
  }
};

const setLoading = () => {
  loading.value = !loading.value;
};

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.pasted_listing_text = "";
  listingForm.selectedMultiple = [];
  listingForm.notes = "";
  listingForm.salary_from = null;
  listingForm.salary_to = null;
  listingForm.contact_name = "";
  listingForm.contact_phone = "";
  listingForm.contact_email = "";
  listingForm.location = "";
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
