<template>
  <div class="w-60 flex flex-col gap-0.5">
    <!-- <form>
      <XInput label="Tag Name" v-model="tagForm.title" />
      <x-select v-model="tagForm.color" label="Tag Color" :options="options" placeholder="Placeholder" class="" />
      <x-button @click="submitTagForm">Add Tag</x-button>
    </form> -->

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
          <XInput size="md" label="Tag Name" v-model="tagForm.title" class="w-full" />
          <section>
            <p class="font-medium text-gray-800 mb-1">Tag Color</p>
            <div class="flex items-center">
              <div v-for="color in colors" :key="color.id">
                <div
                  class="p-[2px] rounded-full cursor-pointer"
                  :class="tagForm.color === color.title ? selectedColorVariants[color.title].outline : 'border border-transparent'"
                >
                  <div
                    class="w-6 h-6 rounded-full flex justify-center items-center"
                    :class="tagForm.color === color.title ? selectedColorVariants[color.title].circle : colorVariants[color.title]"
                    @click="tagForm.color = color.title"
                  >
                    <Icon v-if="tagForm.color == color.title" icon="fluent:checkmark-12-filled" class="text-white" />
                  </div>
                </div>
              </div>
            </div>
            <XButton size="sm" class="mt-4" @click="submitTagForm">Add Tag</XButton>
          </section>
        </form>
      </Transition>
    </div>

    <!-- <x-popover align="right" @close="togglePopover">
      <button type="button" class="ml-auto" @click="togglePopover">
        <Icon icon="charm:plus" />
      </button>
      <template #content>
        <x-popover-container @click.stop>
          <form class="p-2 space-y-4" :class="showContent ? 'opacity-100' : 'opacity-0'">
            <XInput size="md" label="Tag Name" v-model="tagForm.title" class="w-full" />
            <section>
              <p class="font-medium text-gray-800 mb-1">Tag Color</p>
              <div class="flex items-center">
                <div v-for="color in colors" :key="color.id">
                  <div
                    class="p-[2px] rounded-full cursor-pointer"
                    :class="tagForm.color === color.title ? selectedColorVariants[color.title].outline : 'border border-transparent'"
                  >
                    <div
                      class="w-6 h-6 rounded-full flex justify-center items-center"
                      :class="tagForm.color === color.title ? selectedColorVariants[color.title].circle : colorVariants[color.title]"
                      @click="tagForm.color = color.title"
                    >
                      <Icon v-if="tagForm.color == color.title" icon="fluent:checkmark-12-filled" class="text-white" />
                    </div>
                  </div>
                </div>
              </div>
              <XButton size="sm" class="mt-4" @click="submitTagForm">Add Tag</XButton>
            </section>
          </form>
        </x-popover-container>
      </template>
    </x-popover> -->
  </div>
</template>

<script setup>
import { XInput, XPopover, XSelect, XButton } from "@indielayer/ui";
import { onClickOutside } from "@vueuse/core";
import { Icon } from "@iconify/vue";
import { ref, Transition } from "vue";
import { useForm } from "@inertiajs/vue3";

const contentRef = ref(null);
const showContent = ref(false);
const selected = ref("amber");

onClickOutside(contentRef, () => {
  showContent.value = false;
});

const togglePopover = () => {
  showContent.value = !showContent.value;
  // console.log(showContent.value);
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

const options = [
  { value: "amber", label: "Amber" },
  { value: "emerald", label: "Emerald" },
  { value: "purple", label: "Purple" },
  { value: "red", label: "Red" },
  { value: "blue", label: "Blue" },
  { value: "lime", label: "Lime" },
  { value: "teal", label: "Teal" },
  { value: "rose", label: "Rose" },
];

const colors = ref([
  { id: 1, title: "amber" },
  { id: 2, title: "indigo" },
  { id: 3, title: "violet" },
  { id: 4, title: "emerald" },
  { id: 5, title: "blue" },
  { id: 6, title: "red" },
  { id: 7, title: "lime" },
  { id: 8, title: "teal" },
  { id: 9, title: "rose" },
]);

const colorVariants = {
  amber: "bg-amber-200/80",
  indigo: "bg-indigo-200/80",
  violet: "bg-violet-200/80",
  emerald: "bg-emerald-200/80",
  blue: "bg-blue-200/80",
  red: "bg-red-200/80",
  lime: "bg-lime-200/80",
  teal: "bg-teal-200/80",
  rose: "bg-rose-200/80",
};

const selectedColorVariants = {
  amber: { circle: "bg-amber-500", outline: "border border-amber-500" },
  indigo: { circle: "bg-indigo-500", outline: "border border-indigo-500" },
  violet: { circle: "bg-violet-500", outline: "border border-violet-500" },
  emerald: { circle: "bg-emerald-500", outline: "border border-emerald-500" },
  blue: { circle: "bg-blue-500", outline: "border border-blue-500" },
  red: { circle: "bg-red-500", outline: "border border-red-500" },
  lime: { circle: "bg-lime-500", outline: "border border-lime-500" },
  teal: { circle: "bg-teal-500", outline: "border border-teal-500" },
  rose: { circle: "bg-rose-500", outline: "border border-rose-500" },
};
</script>
