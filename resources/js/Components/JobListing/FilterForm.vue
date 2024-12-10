<template>
  <div>
    <BaseModal
      button-text="Filter"
      :show-modal="showFilterModal"
      @close="filterFormDismissed"
      @save="applyFilters"
      title="Filters"
    >
      <template #content>
        <form class="w-full space-y-4">
          <div class="flex items-center justify-between pb-2">
            <label class="text-[17px] font-medium">Show Bookmarked Only</label>
            <XToggle v-model="filterForm.show_bookmarked_only" />
          </div>

          <div class="mb-4 flex w-full items-center justify-between">
            <label class="font-medium">Tags</label>
            <AddTagWidget class="z-50" />
          </div>
          <div class="flex flex-wrap items-center gap-x-1.5 gap-y-2">
            <div v-for="tag in tags" :key="tag.id">
              <div
                v-if="!filterForm.selectedTags.includes(tag.id)"
                @click="addToSelectedTags(tag.id)"
                class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold"
                :class="colorVariants[tag.color]"
              >
                <p>{{ tag.title }}</p>
              </div>
              <div
                v-if="filterForm.selectedTags.includes(tag.id)"
                @click="removeFromSelectedTags(tag.id)"
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

          <div class="flex w-full items-center gap-2">
            <section class="mt-2 w-full">
              <XInput
                type="number"
                label="Min. Salary"
                placeholder="2.000"
                class="w-full"
                v-model="filterForm.salary_from"
              />
              <p class="form-error">{{ filterForm.errors.salary_from }}</p>
            </section>

            <section class="mt-2 w-full">
              <XInput
                type="number"
                label="Max. Salary"
                placeholder="3.500"
                v-model="filterForm.salary_to"
                class="w-full"
              />
              <p class="form-error">{{ filterForm.errors.salary_to }}</p>
            </section>
          </div>
          <div>
            <section>
              <XInput
                label="Location"
                placeholder="Amsterdam"
                class="w-full"
                v-model="filterForm.location"
              />
              <p class="form-error">{{ filterForm.errors.location }}</p>
            </section>
          </div>
        </form>
      </template>
    </BaseModal>
  </div>
</template>

<script setup>
import AddTagWidget from "../Tags/AddTagWidget.vue";
import { useUIStore } from "@/State/UIStore";
import { colorVariants, selectedColorVariants } from "@/Utils/TagColors";
import { useUserStore } from "@/State/UserStore";
import BaseModal from "../UI/BaseModal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { XInput, XToggle } from "@indielayer/ui";

const props = defineProps({
  showFilterModal: Boolean,
});

const emit = defineEmits(["close"]);

const userStore = useUserStore();
const uiStore = useUIStore();

const tags = userStore.state.userTags;

const filterForm = useForm({
  location: uiStore.state.activeFilters.location ?? "",
  salary_from: uiStore.state.activeFilters.salary_from ?? null,
  salary_to: uiStore.state.activeFilters.salary_to ?? null,
  selectedTags: [],
  search_term: uiStore.state.searchTerm,
  show_bookmarked_only:
    uiStore.state.activeFilters.show_bookmarked_only ?? false,
});

watch(
  () => props.showFilterModal,
  (newVal) => {
    if (newVal) {
      filterForm.selectedTags = [];
      uiStore.state.activeFilters.selectedTags?.forEach((id) => {
        addToSelectedTags(parseInt(id));
      });
    }
  },
);

const addToSelectedTags = (id) => {
  filterForm.selectedTags.push(id);
};

const removeFromSelectedTags = (id) => {
  filterForm.selectedTags = filterForm.selectedTags.filter((item) => {
    return item !== id;
  });
};

const applyFilters = () => {
  filterForm.get(route("job-listing.index"), {
    preserveScroll: true,
    onSuccess: () => {
      emit("close");
    },
  });
};

const filterFormDismissed = () => {
  emit("close");
};
</script>
