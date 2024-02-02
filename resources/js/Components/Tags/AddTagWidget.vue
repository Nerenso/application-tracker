<template>
  <div class="w-60 flex flex-col gap-0.5">
    <div class="relative w-full flex justify-end">
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
          class="p-2 space-y-4 absolute right-0 bg-white top-6 origin-top-right shadow-lg rounded-lg border transition-all duration-150 -translate-y-4"
          ref="contentRef"
        >
          <XInput size="md" label="Tag Name" v-model="tagForm.title" class="w-full" placeholder="Marketing" />
          <p v-if="tagForm.errors.title" class="form-error">{{ tagForm.errors.title }}</p>
          <section>
            <p class="font-medium text-gray-800 mb-1">Tag Color</p>
            <div class="flex items-center">
              <div v-for="(color, index) in colorLabels" :key="index">
                <div
                  class="p-[2px] rounded-full cursor-pointer"
                  :class="tagForm.color === color ? activeColorWithRing[color].outline : 'border border-transparent'"
                >
                  <div
                    class="w-6 h-6 rounded-full flex justify-center items-center"
                    :class="tagForm.color === color ? activeColorWithRing[color].circle : colorVariants[color]"
                    @click="tagForm.color = color"
                  >
                    <Icon v-if="tagForm.color == color" icon="fluent:checkmark-12-filled" class="text-white" />
                  </div>
                </div>
              </div>
            </div>

            <XButton size="sm" class="mt-4" @click="submitTagForm">Add Tag</XButton>
          </section>
        </form>
      </Transition>
    </div>
  </div>
</template>

<script setup>
import { XInput, XButton } from "@indielayer/ui";
import { colorVariants, activeColorWithRing, colorLabels } from "@/Utils/TagColors";
import { onClickOutside } from "@vueuse/core";
import { Icon } from "@iconify/vue";
import { ref, Transition } from "vue";
import { useForm } from "@inertiajs/vue3";

const contentRef = ref(null);
const showContent = ref(false);

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

const submitTagForm = () => {
  tagForm.post(route("tag.store"), {
    onSuccess: () => resetForm(),
  });
};
</script>
