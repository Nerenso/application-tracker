<template>
  <article class="relative h-8">
    <div
      v-if="showMenu"
      @click.stop="showMenu = !showMenu"
      class="fixed left-0 top-0 h-full w-full cursor-default"
    />
    <button v-if="!editMode" @click.stop="showMenu = !showMenu" class="">
      <Icon
        class="h-8 w-8 rounded-lg p-1 transition-all duration-100 hover:bg-slate-50"
        icon="fluent:more-vertical-20-regular"
      />
    </button>

    <div v-if="editMode && inlineEdit" class="flex h-8 items-center">
      <button class="text-slate-600" as="button" @click="">
        <Icon
          icon="fluent:save-16-regular"
          class="h-[28px] w-[28px] rounded-lg p-1 transition-all duration-100 hover:bg-slate-50"
        />
      </button>
      <button class="text-slate-600" as="button" @click="editMode = false">
        <Icon
          icon="fluent:dismiss-16-filled"
          class="h-8 w-8 rounded-lg p-2 transition-all duration-100 hover:bg-slate-50"
        />
      </button>
    </div>
    <div
      ref="menuPanel"
      class="absolute right-2 top-8 z-10 min-w-[140px] origin-top-right rounded-lg border bg-white p-2 shadow-lg transition-all duration-100"
      :class="
        showMenu
          ? 'visible translate-y-0 scale-100 opacity-100'
          : 'invisible -translate-y-4 scale-90 opacity-0'
      "
    >
      <button
        @click.stop="handleEdit"
        class="flex w-full items-center justify-start gap-1 rounded-md p-2 transition-all duration-150 hover:bg-slate-50"
      >
        <Icon icon="fluent:edit-32-regular" class="h-5 w-5 p-[1.5px]" />
        <span>Edit</span>
      </button>
      <button
        @click.stop="handleDelete"
        class="flex w-full items-center justify-start gap-1 rounded-md p-2 transition-all duration-150 hover:bg-slate-50"
      >
        <Icon
          icon="fluent:bin-recycle-24-regular"
          class="-mt-[1.5px] h-5 w-5 p-[1px]"
        />
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
