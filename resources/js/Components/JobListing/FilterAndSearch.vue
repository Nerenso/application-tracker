<template>
  <div class="my-4 flex gap-2">
    <form
      class="flex w-full overflow-hidden rounded-lg border border-2 border-teal-400/0 bg-white"
      :class="{ 'border-teal-400/100': searchFocused }"
      @submit.prevent="handleSearch"
    >
      <input
        type="text"
        placeholder="Enter a search term"
        class="w-full py-3 pl-3 outline-none"
        enterkeyhint="search"
        v-model="searchForm.search_term"
        @focus="searchFocused = true"
        @blur="searchFocused = false"
        @keydown.enter.prevent="handleSearch"
      />
      <Link
        :href="route('job-listing.index')"
        class="flex items-center justify-center pb-0.5 pr-2"
        v-if="searchForm.search_term"
        @click="resetSearchTerm"
      >
        <Icon
          icon="fluent:dismiss-16-filled"
          class="h-[15px] w-[15px] text-slate-900"
        />
      </Link>
      <button type="submit" class="pr-3.5">
        <Icon icon="heroicons-outline:search" class="h-5 w-5 text-slate-400" />
      </button>
    </form>
  </div>
  <div
    class="flex items-center justify-between"
    :class="uiStore.state.activeFilters ? 'mb-2' : 'mb-6'"
  >
    <button
      @click="showFilterModal = true"
      class="flex items-center justify-center gap-1 rounded-md py-2 pl-1 pr-3 text-slate-600"
    >
      <Icon icon="mage:filter-fill" class="h-4 w-4" />
      <span class="text-sm font-medium">Filters</span>
    </button>
  </div>

  <div v-if="uiStore.state.filteredResults" class="mb-8 flex flex-wrap gap-2">
    <ActiveFilterBox v-if="uiStore.state.activeFilters?.selectedTags?.length">
      <p class="text-sm font-medium">Tags:&nbsp;</p>
      <div
        v-for="(tag, index) in tagsToDisplay"
        :key="tag.id"
        class="flex text-sm"
      >
        <p>
          {{ tag.title }}
        </p>
        <span v-if="index < tagsToDisplay.length - 1">,&nbsp;</span>
      </div>
    </ActiveFilterBox>

    <ActiveFilterBox v-if="uiStore.state.activeFilters?.location">
      <p class="text-sm font-medium">
        Location:
        <span class="text-sm font-normal capitalize">
          {{ uiStore.state.activeFilters.location }}
        </span>
      </p>
    </ActiveFilterBox>

    <ActiveFilterBox v-if="uiStore.state.activeFilters?.show_bookmarked_only">
      <p class="text-sm font-medium">Bookmarked Listings</p>
    </ActiveFilterBox>

    <ActiveFilterBox v-if="getSalaryRangeText()">
      <p class="text-sm font-medium">
        Salary:
        <span class="text-sm font-normal">
          {{ getSalaryRangeText() }}
        </span>
      </p>
    </ActiveFilterBox>
    <Link
      class="rounded-lg border border-rose-300 px-2 py-1 text-sm font-medium text-rose-500 md:px-3 md:py-2"
      :href="route('job-listing.index')"
      >Clear Filters</Link
    >
  </div>

  <FilterForm :show-filter-modal="showFilterModal" @close="hideFilterModal" />
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { useUIStore } from "@/State/UIStore";
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FilterForm from "./FilterForm.vue";
import { useUserStore } from "@/State/UserStore";
import ActiveFilterBox from "../UI/ActiveFilterBox.vue";

const searchFocused = ref(false);
const showFilterModal = ref(false);

const uiStore = useUIStore();
const userStore = useUserStore();

const searchForm = useForm({
  search_term: uiStore.state.searchTerm,
});

let tagsToDisplay = [];

if (uiStore.state.activeFilters?.selectedTags?.length) {
  tagsToDisplay = uiStore.state.activeFilters.selectedTags.map((tagID) => {
    return userStore.state.userTags.find((tag) => tag.id === parseInt(tagID));
  });
}

const getSalaryRangeText = () => {
  if (
    uiStore.state.activeFilters?.salary_from &&
    uiStore.state.activeFilters?.salary_to
  ) {
    return `€${uiStore.state.activeFilters?.salary_from.toLocaleString("nl-NL")} - €${uiStore.state.activeFilters?.salary_to.toLocaleString("nl-NL")}`;
  } else if (
    !uiStore.state.activeFilters?.salary_from &&
    uiStore.state.activeFilters?.salary_to
  ) {
    return `up to €${uiStore.state.activeFilters?.salary_to.toLocaleString("nl-NL")}`;
  } else if (
    uiStore.state.activeFilters?.salary_from &&
    !uiStore.state.activeFilters?.salary_to
  ) {
    return `starting from €${uiStore.state.activeFilters?.salary_from.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};

const handleSearch = () => {
  searchForm.get(route("job-listing.index"), {
    preserveScroll: true,
  });
};

const resetSearchTerm = () => {
  searchForm.search_term = "";
};

const hideFilterModal = () => {
  showFilterModal.value = false;
};
</script>
