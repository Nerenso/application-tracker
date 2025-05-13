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
        class="fixed top-0 z-40 h-screen w-full flex-col items-center justify-start overflow-hidden overflow-y-auto bg-black/50 p-4 sm:flex"
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
      @enter="$emit('beforeEnter')"
      @after-leave="$emit('afterLeave')"
    >
      <div
        v-show="showModal"
        class="fixed bottom-0 left-0 right-0 top-0 z-50 m-auto flex w-full max-w-2xl origin-bottom flex-col items-end justify-end overflow-hidden"
        @keyup.enter="handleEnter"
      >
        <section
          ref="contentRef"
          class="bottom-0 mx-auto flex h-[95dvh] w-full max-w-screen-sm origin-top flex-col overflow-hidden rounded-tl-lg rounded-tr-lg bg-white shadow-[rgba(0,0,0,0.2)0px_-6px_12px_0px] sm:m-auto sm:h-fit sm:max-h-[90vh] sm:rounded-lg sm:shadow-none"
        >
          <header
            class="z-10 flex items-center justify-between border-b px-6 py-6 shadow-sm sm:shadow-none"
          >
            <h4>{{ title }}</h4>
            <button
              class="block text-slate-700"
              as="button"
              @click="handleCancel"
            >
              <Icon icon="fluent:dismiss-16-filled" class="h-5 w-5" />
            </button>
          </header>
          <section class="flex-1 overflow-y-auto px-6 py-4">
            <slot name="content"></slot>
          </section>
          <footer
            v-if="!customFooter"
            class="z-20 flex items-center justify-end gap-2 border-t bg-slate-50 px-6 pb-6 pt-4 shadow-[rgba(0,0,0,0.05)0px_-1px_2px_0px] sm:pb-4 sm:pt-4 sm:shadow-none"
          >
            <XButton
              size="md"
              @click="handleCancel"
              class="h-[50px] w-full sm:h-fit sm:w-fit"
              >Cancel</XButton
            >

            <XButton
              size="md"
              :color="buttonColor"
              @click="handleSave"
              class="h-[50px] w-full sm:h-fit sm:w-fit"
              :loading="loading"
              >{{ buttonText }}</XButton
            >
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
  buttonText: String,
  buttonColor: {
    type: String,
    default: "primary",
  },
  saveOnEnterKeyUp: {
    type: Boolean,
    default: false,
  },
  showModal: Boolean,
  loading: Boolean,
  customFooter: Boolean,
});

const contentRef = ref(null);
const emit = defineEmits(["close", "save", "beforeEnter", "afterLeave"]);

onClickOutside(contentRef, () => {
  emit("close");
});

function handleCancel() {
  emit("close");
}

function handleSave() {
  emit("save");
}

const handleEnter = () => {
  if (props.saveOnEnterKeyUp) {
    emit("save");
  }
};
</script>
