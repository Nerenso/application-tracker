<template>
  <Teleport to="body">
    <div>
      <Presence>
        <Motion
          v-if="show"
          @click="hideSideBar"
          class="fixed top-0 bg-black/40 dark:bg-black/60 h-screen w-full z-40"
          :initial="{ opacity: 0 }"
          :animate="{ opacity: 1 }"
          :exit="{ opacity: 0 }"
          :transition="{ duration: 0.3 }"
        />
      </Presence>

      <Presence>
        <Motion
          v-if="show"
          class="fixed h-[100dvh] bg-white z-50 shadow-lg"
          :class="[positionOptions[position], widthOptions[width]]"
          :initial="{ x: position == 'left' ? -440 : 440 }"
          :animate="{ x: 0 }"
          :exit="{ x: position == 'left' ? -440 : 440 }"
          :transition="{ duration: 0.3 }"
        >
          <slot></slot>
        </Motion>
      </Presence>
    </div>
  </Teleport>
</template>

<script setup>
import { Motion, Presence } from "motion/vue";
import { watch } from "vue";
import { ref } from "vue";

const props = defineProps({
  isVisible: Boolean,
  position: {
    type: String,
    required: true,
  },
  width: String,
});

const emit = defineEmits(["close"]);
const show = ref(false);

const positionOptions = {
  left: "top-0 left-0",
  right: "top-0 right-0",
};

const widthOptions = {
  xs: "w-[200px]",
  sm: "w-[260px]",
  md: "w-[320px]",
  lg: "w-[440px]",
};

const hideSideBar = () => {
  emit("close");
  show.value = false;
};

const showSideBar = () => {
  show.value = true;
};

const getWidthClass = (width) => {
  return `w-[${width}px]`;
};

watch(
  () => props.isVisible,
  (val) => {
    if (val) {
      showSideBar();
    } else {
      hideSideBar();
    }
  }
);
</script>
