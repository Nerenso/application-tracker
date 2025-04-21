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
        @click.stop="handleEdit"
      />
      <ActionMenuButton
        iconName="f7:status"
        buttonText="Change Status"
        @click.stop="handleEdit"
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
  </article>
</template>

<script setup>
import BaseActionMenu from "@/Components/UI/BaseActionMenu.vue";
import ActionMenuButton from "@/Components/UI/ActionMenuButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import BaseIconButton from "@/Components/UI/BaseIconButton.vue";

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["edit", "delete"]);
const isMenuOpen = ref(false);

const handleEdit = () => {
  emit("edit");
  isMenuOpen.value = false;
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
</script>
