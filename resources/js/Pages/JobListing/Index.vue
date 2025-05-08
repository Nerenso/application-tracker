<template>
  <DashboardLayout title="Saved Listings" :show-top-bar="true">
    <template #actions>
      <XButton
        color="primary"
        @click="showAddListingForm"
        class="hidden md:block"
        >Add Listing</XButton
      >
      <div
        @click="showAddListingForm"
        class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-500 text-white md:hidden"
      >
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <Head title="Saved Listings" />
    <div class="min-h-screen w-full">
      <section
        v-if="listings.data.length <= 0 && !filteredResults && !searchTerm"
        class="w-full p-2"
      >
        <EmptyState>
          <div class="mb-4 flex flex-col gap-4">
            <p class="empty-state-text">
              You haven't saved any job listings yet. Try adding a listing.
            </p>
            <XButton
              class="mx-auto w-fit"
              color="primary"
              @click="showAddListingForm"
              >Add New Listing</XButton
            >
          </div>
        </EmptyState>
      </section>

      <section v-else class="w-full p-2 md:p-6">
        <div class="mx-auto w-full max-w-5xl">
          <FilterAndSearch />
          <div
            v-if="listings.data.length > 0"
            class="my-4 grid grid-cols-1 gap-6"
          >
            <JobListing
              v-for="listing in listings.data"
              :key="listing.id"
              :listing-info="listing"
              :tags="tags"
              @edit="openEditModal(listing)"
              @click="showDetailPage(listing.id)"
            />
          </div>

          <article
            v-if="
              (listings.data.length <= 0 && filteredResults) ||
              (listings.data.length <= 0 && searchTerm)
            "
          >
            <div class="rounded-lg border border-dashed border-slate-300 p-4">
              <p class="empty-state-text">
                No results found that match the applied filters or entered
                search term.
              </p>
            </div>
          </article>
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

    <AddListingForm />

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
import { useUserStore } from "@/State/UserStore";
import { useUIStore } from "@/State/UIStore";
import EmptyState from "@/Components/UI/EmptyState.vue";
import JobListing from "@/Components/JobListing/JobListing.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import { Icon } from "@iconify/vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { XButton } from "@indielayer/ui";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import BaseNoticeModal from "@/Components/UI/BaseNoticeModal.vue";
import FilterAndSearch from "@/Components/JobListing/FilterAndSearch.vue";
import AddListingForm from "@/Components/JobListing/AddListingForm.vue";

const props = defineProps({
  listings: Object,
  filters: Object,
  filteredResults: Boolean,
  tags: Array,
  listings_paginator: Object,
  searchTerm: String,
  verified: String,
});

const showNotice = ref(false);
const showEditModal = ref(false);
const listingToEdit = ref(null);
const userStore = useUserStore();
const uiStore = useUIStore();

userStore.actions.setUserTags(props.tags);
uiStore.actions.setActiveFilters(props.filters);
uiStore.actions.setFilteredResults(props.filteredResults);
uiStore.actions.setSearchTerm(props.searchTerm);

const showAddListingForm = () => {
  uiStore.actions.setShowAddListingForm(true);
};

const getResultsInfo = () => {
  let multiplier = props.listings_paginator.currentPage - 1;
  let itemCount = props.listings_paginator.count;
  let listingsPerPage = props.listings_paginator.listingsPerPage;
  let total = props.listings_paginator.total;

  let startItemNumber = listingsPerPage * multiplier + 1;
  let lastItemNumber = listingsPerPage * multiplier + itemCount;

  return { startItemNumber, lastItemNumber, total };
};

const showDetailPage = (listingId) => {
  router.visit(route("job-listing.show", listingId));
};

const openEditModal = (selectedListing) => {
  listingToEdit.value = selectedListing;
  showEditModal.value = true;
};
</script>
