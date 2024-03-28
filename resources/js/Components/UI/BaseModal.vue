<template>
  <Teleport to="body">
    <Transition
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      enter-active-class="transition-all ease-in duration-200"
      leave-active-class="delay-100 transition-all ease duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showModal"
        class="fixed top-0 w-full h-screen overflow-hidden overflow-y-scroll bg-black/50 flex flex-col justify-start items-center p-4 z-40"
      ></div>
    </Transition>
    <Transition
      mode="out-in"
      enter-from-class="opacity-0 scale-95 -translate-y-2"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      enter-active-class="delay-75 transition-all duration-200 origin-center"
      leave-active-class=" transition-all duration-200 origin-center"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 -translate-y-2"
      appear
    >
      <div
        v-show="showModal"
        ref="contentRef"
        class="fixed top-0 w-full max-w-2xl origin-top right-0 left-0 bottom-0 m-auto overflow-hidden h-fit flex flex-col px-4 z-50"
      >
        <section
          class="w-full max-w-2xl bg-white rounded-lg origin-top right-0 left-0 bottom-0 m-auto overflow-hidden h-fit max-h-[80vh] flex flex-col"
        >
          <header class="px-6 py-4 border-b">
            <h4>{{ title }}</h4>
          </header>
          <section class="px-6 py-4 flex-1 overflow-y-scroll">
            <slot name="content"></slot>
          </section>
          <footer class="px-6 py-4 flex gap-4 items-center justify-end bg-slate-50">
            <XButton @click="handleCancel">Cancel</XButton>
            <slot name="action">
              <!-- <XButton color="primary">{{ successButton }}</XButton> -->
            </slot>
          </footer>
        </section>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { XButton } from "@indielayer/ui";
import { onClickOutside } from "@vueuse/core";
import { ref } from "vue";

const props = defineProps({
  title: String,
  successButton: String,
  showModal: Boolean,
});

const contentRef = ref(null);
const emit = defineEmits(["close"]);

onClickOutside(contentRef, () => {
  emit("close");
});

function handleCancel() {
  emit("close");
}
</script>
