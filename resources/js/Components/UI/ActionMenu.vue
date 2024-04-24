<template>
  <article class="relative h-8">
    <div v-if="showMenu" @click.stop="showMenu = !showMenu" class="fixed top-0 left-0 w-full h-full" />
    <button v-if="!editMode" @click.stop="showMenu = !showMenu" class="">
      <Icon class="h-8 w-8 p-1 rounded-lg hover:bg-slate-50 transition-all duration-100" icon="fluent:more-vertical-20-regular" />
    </button>

    <div v-if="editMode && inlineEdit" class="flex items-center h-8">
      <button class="text-slate-600" as="button" @click="">
        <Icon icon="fluent:save-16-regular" class="h-[28px] w-[28px] p-1 rounded-lg hover:bg-slate-50 transition-all duration-100" />
      </button>
      <button class="text-slate-600" as="button" @click="editMode = false">
        <Icon icon="fluent:dismiss-16-filled" class="h-8 w-8 p-2 rounded-lg hover:bg-slate-50 transition-all duration-100" />
      </button>
    </div>
    <div
      ref="menuPanel"
      class="p-2 bg-white shadow-lg rounded-lg border min-w-[140px] absolute top-8 right-2 transition-all duration-100 origin-top-right"
      :class="showMenu ? 'translate-y-0 visible scale-100 opacity-100' : '-translate-y-4 invisible scale-90 opacity-0'"
    >
      <button
        @click.stop="handleEdit"
        class="hover:bg-slate-50 w-full transition-all duration-150 rounded-md flex items-center justify-start gap-1 p-2"
      >
        <Icon icon="fluent:edit-32-regular" class="w-5 h-5 p-[1.5px]" />
        <span>Edit</span>
      </button>
      <button
        @click.stop="handleDelete"
        class="hover:bg-slate-50 w-full transition-all duration-150 rounded-md flex items-center justify-start gap-1 p-2"
      >
        <Icon icon="fluent:bin-recycle-24-regular" class="w-5 h-5 p-[1px] -mt-[1.5px]" />
        <span>Delete</span>
      </button>
    </div>
  </article>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { onClickOutside } from "@vueuse/core";
import { XButton, XPopover } from "@indielayer/ui";
import { ref } from "vue";

const props = defineProps({
  inlineEdit: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(["edit", "delete"]);

const showMenu = ref(false);
const editMode = ref(false);
const menuPanel = ref(null);

// onClickOutside(menuPanel, (event) => closeMenu());

const openMenu = () => {
  showMenu.value = true;
};

const closeMenu = () => {
  showMenu.value = false;
};

const handleEdit = () => {
  if (props.inlineEdit) {
    editMode.value = true;
  }
  showMenu.value = false;
  emit("edit");
};

const handleDelete = () => {
  showMenu.value = false;
  emit("delete");
};
</script>
