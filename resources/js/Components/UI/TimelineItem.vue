<template>
  <component :is="as" class="relative -ms-1.5 flex items-start gap-2">
    <div
      class="-ml-0.5 flex size-4 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 bg-white p-[2px]"
    >
      <div class="h-full w-full shrink-0 rounded-full bg-teal-500"></div>
    </div>
    <div class="-mt-1.5 w-full">
      <header class="flex w-full items-center justify-between">
        <div class="">
          <time class="text-xs text-slate-500 dark:text-gray-200">
            {{ getFormattedDate(date) }}
          </time>
          <slot name="title"></slot>
        </div>
        <BaseActionMenu
          v-if="editable"
          :min-width="145"
          v-model:is-open="isMenuOpen"
        >
          <ActionMenuButton
            iconName="fluent:edit-32-regular"
            buttonText="Edit"
            @click.stop="handleEdit"
          />

          <ActionMenuButton
            iconName="fluent:bin-recycle-24-regular"
            buttonText="Delete"
            @click.stop="handleDelete"
          />
        </BaseActionMenu>
      </header>

      <slot name="content"></slot>
    </div>
  </component>
</template>

<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import calendar from "dayjs/plugin/calendar";
import BaseActionMenu from "./BaseActionMenu.vue";
import { ref } from "vue";
import ActionMenuButton from "./ActionMenuButton.vue";

dayjs.extend(relativeTime);
dayjs.extend(calendar);

const isMenuOpen = ref(false);

const props = defineProps({
  date: {
    type: String,
    required: true,
  },
  as: {
    type: String,
    default: "div",
  },
  editable: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["edit", "delete"]);

const handleEdit = () => {
  isMenuOpen.value = false;
  emit("edit");
};

const handleDelete = () => {
  isMenuOpen.value = false;
  emit("delete");
};

const getFormattedDate = (date) =>
  dayjs(date).calendar(null, {
    sameDay: `[Today at] HH:mm`, // The same day ( Today at 2:30 AM )
    nextDay: "[Tomorrow]", // The next day ( Tomorrow at 2:30 AM )
    nextWeek: "dddd", // The next week ( Sunday at 2:30 AM )
    lastDay: "[Yesterday at] HH:mm", // The day before ( Yesterday at 2:30 AM )
    lastWeek: "[Last] dddd [at] HH:mm", // Last week ( Last Monday at 2:30 AM )
    sameElse: "MMMM DD, YYYY", // Everything else ( 7/10/2011 )
  });
</script>
