<template>
  <Teleport to="body">
    <Transition
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      enter-active-class="transition-all ease-in duration-200"
      leave-active-class=" delay-100 transition-all ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showModal"
        class="sm:flex fixed top-0 w-full h-screen overflow-hidden overflow-y-scroll bg-black/50 flex-col justify-start items-center p-4 z-40"
      ></div>
    </Transition>
    <Transition
      mode="out-in"
      enter-from-class="opacity-100 sm:opacity-0 scale-95 translate-y-full sm:-translate-y-2"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      enter-active-class="delay-75 transition-all duration-200 origin-center"
      leave-active-class=" transition-all duration-300 sm:duration-200 origin-center"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-100 sm:opacity-0 scale-95 translate-y-full sm:-translate-y-2"
      appear
    >
      <div
        v-show="showModal"
        class="fixed top-0 w-full max-w-2xl origin-bottom right-0 left-0 bottom-0 m-auto overflow-hidden flex flex-col items-end justify-end z-50"
      >
        <section
          ref="contentRef"
          class="w-full max-w-screen-sm rounded-tl-lg rounded-tr-lg bg-white h-[95dvh] sm:rounded-lg sm:max-h-[90vh] sm:h-fit origin-top bottom-0 mx-auto sm:m-auto overflow-hidden flex flex-col shadow-[rgba(0,0,0,0.2)0px_-6px_12px_0px] sm:shadow-none"
        >
          <header class="px-6 py-6 border-b shadow-sm sm:shadow-none z-10 flex items-center justify-between">
            <h4>{{ title }}</h4>
            <button class="text-slate-700 block sm:hidden" as="button" @click="handleCancel">
              <Icon icon="fluent:dismiss-16-filled" class="w-5 h-5" />
            </button>
          </header>
          <section class="px-6 py-4 flex-1 overflow-y-scroll">
            <slot name="content"></slot>
          </section>
          <footer
            class="border-t shadow-[rgba(0,0,0,0.05)0px_-1px_2px_0px] pb-6 pt-4 sm:shadow-none z-20 px-6 sm:pt-4 sm:pb-4 flex gap-2 items-center justify-end bg-slate-50"
          >
            <XButton size="md" @click="handleCancel" class="w-full h-[50px] sm:h-fit sm:w-fit">Cancel</XButton>

            <XButton size="md" color="primary" @click="handleSave" class="w-full h-[50px] sm:h-fit sm:w-fit" :loading="loading">{{
              successButton
            }}</XButton>
          </footer>
        </section>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { XButton } from "@indielayer/ui";
import { onClickOutside } from "@vueuse/core";
import { ref } from "vue";

const props = defineProps({
  title: String,
  successButton: String,
  showModal: Boolean,
  loading: Boolean,
});

const contentRef = ref(null);
const emit = defineEmits(["close", "save"]);

onClickOutside(contentRef, () => {
  emit("close");
});

function handleCancel() {
  emit("close");
}

function handleSave() {
  emit("save");
}
</script>
