<template>
  <article class="flex items-center">
    <div class="-mr-1 flex items-center">
      <BaseIconButton
        v-if="!listing.is_bookmarked"
        icon="heroicons:bookmark"
        @click="toggleBookmark"
      />
      <BaseIconButton
        v-if="listing.is_bookmarked"
        class="text-teal-500"
        :custom="true"
        icon="heroicons:bookmark-20-solid"
        @click="toggleBookmark"
      />
    </div>
    <BaseActionMenu :minWidth="178" v-model:isOpen="isMenuOpen">
      <ActionMenuButton
        iconName="fluent:edit-32-regular"
        buttonText="Edit"
        @click.stop="setShowListingEditForm(true)"
      />
      <ActionMenuButton
        iconName="f7:status"
        buttonText="Change Status"
        @click.stop="setShowListingStatusForm(true)"
      />
      <ActionMenuButton
        iconName="fluent:task-list-square-16-regular"
        buttonText="Add Todo"
        @click.stop="handleEdit"
      />
      <ActionMenuButton
        iconName="fluent:timeline-24-regular"
        buttonText="Add Activity"
        @click.stop="handleEdit"
      />
      <ActionMenuButton
        iconName="fluent:bin-recycle-24-regular"
        buttonText="Delete"
        @click.stop="handleDelete"
      />
    </BaseActionMenu>

    <ListingStatusForm
      v-if="isSelectedListing()"
      :listing="listing"
      :showModal="showListingStatusForm"
      @close="setShowListingStatusForm(false)"
    />

    <ListingEditForm
      v-if="isSelectedListing()"
      :listing-info="listing"
      :tags="userTags"
      :showModal="showListingEditForm"
      @close="setShowListingEditForm(false)"
    />
  </article>
</template>

<script setup>
import BaseActionMenu from "@/Components/UI/BaseActionMenu.vue";
import ActionMenuButton from "@/Components/UI/ActionMenuButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import BaseIconButton from "@/Components/UI/BaseIconButton.vue";
import ListingStatusForm from "@/Components/JobListing/ListingStatusForm.vue";
import { useUIStore } from "@/State/UIStore";
import { watch } from "vue";
import ListingEditForm from "./ListingEditForm.vue";
import { useUserStore } from "@/State/UserStore";
import { computed } from "vue";

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
});

const uiStore = useUIStore();
const userStore = useUserStore();

const userTags = computed(() => {
  return userStore.state.userTags;
});

const emit = defineEmits(["edit", "delete"]);
const isMenuOpen = ref(false);
const showListingStatusForm = ref(false);
const showListingEditForm = ref(false);

watch(isMenuOpen, (newVal) => {
  if (newVal) {
    uiStore.actions.setSelectedListingID(props.listing.id);
  }
});

const handleEdit = () => {
  isMenuOpen.value = false;
};

const setShowListingStatusForm = (newVal) => {
  if (isSelectedListing()) {
    showListingStatusForm.value = newVal;
    isMenuOpen.value = false;
  }
};

const setShowListingEditForm = (newVal) => {
  if (isSelectedListing()) {
    showListingEditForm.value = newVal;
    isMenuOpen.value = false;
  }
};

const handleDelete = () => {
  emit("delete");
  isMenuOpen.value = false;
};

const toggleBookmark = () => {
  router.visit(route("job-listing.bookmark", props.listing.id), {
    method: "patch",
    preserveScroll: true,
  });
};

const isSelectedListing = () => {
  return uiStore.state.selectedListingID === props.listing.id;
};
</script>
