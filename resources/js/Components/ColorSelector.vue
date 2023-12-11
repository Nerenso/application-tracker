<template>
  <div class="w-60 flex flex-col gap-0.5">
    <form>
      <XInput label="Tag Name" v-model="tagForm.title" />
      <x-select v-model="tagForm.color" label="Tag Color" :options="options" placeholder="Placeholder" class="" />
      <x-button @click="submitTagForm">Add Tag</x-button>
    </form>
    <!-- <x-popover align="left">
      <x-button>Click me to open popover</x-button>
      <template #content>
        <x-popover-container class="p-2 space-y-4" @click.stop>

          <section>
            <p class="font-medium text-gray-800 mb-1">Tag Color</p>
            <div class="flex items-center">
              <div v-for="color in colors" :key="color.id">
                <div
                  class="p-[2px] rounded-full cursor-pointer"
                  :class="selected === color.title ? selectedColorVariants[color.title].outline : 'border border-transparent'"
                >
                  <div
                    class="w-6 h-6 rounded-full flex justify-center items-center"
                    :class="selected === color.title ? selectedColorVariants[color.title].circle : colorVariants[color.title]"
                    @click="selected = color.title"
                  >
                    <Icon v-if="selected == color.title" icon="fluent:checkmark-12-filled" class="text-white" />
                  </div>
                </div>
              </div>
            </div>
          </section>
        </x-popover-container>
      </template>
    </x-popover> -->
  </div>
</template>

<script setup>
import { XInput, XPopover, XSelect } from "@indielayer/ui";
import { Icon } from "@iconify/vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const selected = ref("amber");

const dropDownSelected = ref("");

const tagForm = useForm({
  title: "",
  color: "",
});

const submitTagForm = () => {
  tagForm.post(route("tag.store"));
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
]);

const colorVariants = {
  amber: "bg-amber-200/80",
  indigo: "bg-indigo-200/80",
  violet: "bg-violet-200/80",
  emerald: "bg-emerald-200/80",
  blue: "bg-blue-200/80",
  red: "bg-red-200/80",
};

const selectedColorVariants = {
  amber: { circle: "bg-amber-500", outline: "border border-amber-500" },
  indigo: { circle: "bg-indigo-500", outline: "border border-indigo-500" },
  violet: { circle: "bg-violet-500", outline: "border border-violet-500" },
  emerald: { circle: "bg-emerald-500", outline: "border border-emerald-500" },
  blue: { circle: "bg-blue-500", outline: "border border-blue-500" },
  red: { circle: "bg-red-500", outline: "border border-red-500" },
};
</script>
