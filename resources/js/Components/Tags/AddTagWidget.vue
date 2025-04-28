<template>
  <div class="flex w-60 flex-col gap-0.5">
    <div class="relative flex w-full justify-end">
      <button type="button" class="ml-auto" @click="togglePopover">
        <Icon icon="charm:plus" />
      </button>

      <Transition
        enter-active-class="transition-all duration-150 origin-top-right"
        leave-active-class="transition-all duration-150 origin-top-right -translate-y-4"
        enter-from-class="opacity-0 scale-90 -translate-y-4"
        enter-to-class="opacity-100 scale-100 translate-y-0"
        leave-from-class="opacity-100 scale-100 translate-y-0"
        leave-to-class="opacity-0 scale-90 -translate-y-4"
      >
        <form
          v-if="showContent"
          appear
          class="absolute right-0 top-6 origin-top-right -translate-y-4 space-y-4 rounded-lg border bg-white p-2 shadow-lg transition-all duration-150"
          ref="contentRef"
        >
          <XInput
            size="md"
            label="Tag Name"
            v-model="tagForm.title"
            class="w-full"
            placeholder="Marketing"
          />
          <p v-if="tagForm.errors.title" class="form-error">
            {{ tagForm.errors.title }}
          </p>
          <section>
            <p class="mb-1 font-medium text-gray-800">Tag Color</p>
            <div class="flex items-center">
              <div v-for="(color, index) in colorLabels" :key="index">
                <div
                  class="cursor-pointer rounded-full p-[2px]"
                  :class="
                    tagForm.color === color
                      ? activeColorWithRing[color].outline
                      : 'border border-transparent'
                  "
                >
                  <div
                    class="flex h-6 w-6 items-center justify-center rounded-full"
                    :class="
                      tagForm.color === color
                        ? activeColorWithRing[color].circle
                        : tagColorPickerVariants[color]
                    "
                    @click="tagForm.color = color"
                  >
                    <Icon
                      v-if="tagForm.color == color"
                      icon="fluent:checkmark-12-filled"
                      class="text-white"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div class="flex w-full justify-end gap-2">
              <XButton size="sm" class="mt-4" @click="resetForm()"
                >Cancel</XButton
              >
              <XButton
                size="sm"
                color="primary"
                class="mt-4"
                @click="submitTagForm"
                >Add Tag</XButton
              >
            </div>
          </section>
        </form>
      </Transition>
    </div>
  </div>
</template>

<script setup>
import { XInput, XButton } from "@indielayer/ui";
import {
  colorVariants,
  activeColorWithRing,
  colorLabels,
  tagColorPickerVariants,
} from "@/Utils/TagColors";
import { onClickOutside } from "@vueuse/core";
import { Icon } from "@iconify/vue";
import { ref, Transition } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { useUserStore } from "@/State/UserStore";

const contentRef = ref(null);
const showContent = ref(false);
const userStore = useUserStore();

onClickOutside(contentRef, () => {
  showContent.value = false;
  resetForm();
});

const togglePopover = () => {
  showContent.value = !showContent.value;
};

const tagForm = useForm({
  title: "",
  color: "amber",
});

const resetForm = () => {
  tagForm.title = "";
  tagForm.color = "amber";
  showContent.value = false;
};

async function fetchTags() {
  try {
    const response = await axios.get("/api/tags");
    userStore.actions.setUserTags(response.data.tags);
  } catch (error) {
    console.error("Error fetching tags:", error);
  }
}

const submitTagForm = () => {
  tagForm.post(route("tag.store"), {
    onSuccess: () => {
      resetForm();
      fetchTags();
    },
  });
};
</script>
