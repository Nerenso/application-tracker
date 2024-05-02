<template>
  <ContentBox>
    <article class="rounded-lg p-4 flex items-center justify-between bg-white">
      <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded-full" :class="selectedColorVariants[tag.color]"></div>
        <p>{{ tag.title }}</p>
      </div>
      <ActionMenu class="-mr-2" :inline-edit="false" @edit="handleEdit" @delete="handleDelete" />
    </article>
  </ContentBox>
</template>

<script setup>
import { colorVariants, activeColorWithRing, colorLabels, selectedColorVariants } from "@/Utils/TagColors";
import ActionMenu from "@/Components/UI/ActionMenu.vue";
import ContentBox from "@/Components/UI/ContentBox.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  tag: Object,
});

const emit = defineEmits(["edit"]);

const handleEdit = () => {
  emit("edit");
};

const handleDelete = () => {
  router.delete(route("tag.destroy", props.tag.id));
};
</script>
