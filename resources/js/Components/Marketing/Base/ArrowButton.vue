<template>
  <button
    @mouseenter="arrowAnimation.play()"
    @mouseleave="arrowAnimation.reverse()"
    class="flex cursor-pointer items-center text-teal-500 transition-all duration-150 hover:text-slate-800"
  >
    <p class="font-semibold">
      <slot>Get Started</slot>
    </p>
    <div class="flex items-center">
      <div ref="dash">
        <Icon icon="bi:dash" class="mt-[2px] h-6 w-6" />
      </div>
      <div ref="caret" class="-ml-3 flex items-center text-xl font-semibold">
        <p>›</p>
      </div>
    </div>
  </button>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { gsap } from "gsap";
import { onMounted } from "vue";
import { ref } from "vue";

const dash = ref(null);
const caret = ref(null);

const arrowAnimation = gsap.timeline({
  paused: true,
});

onMounted(() => {
  handleArrowAnimation();
});

const handleArrowAnimation = () => {
  let responsiveArrowAnimations = gsap.matchMedia();

  responsiveArrowAnimations.add(
    {
      isMobile: "(max-width: 640px)",
      isDesktop: "(min-width: 640px)",
    },
    (context) => {
      let { isMobile, isDesktop } = context.conditions;

      if (isDesktop) {
        arrowAnimation.fromTo(
          dash.value,
          {
            color: "#10b981",
            x: -4,
            opacity: 0,
            duration: 0.1,
            ease: "easeInOut",
          },
          {
            color: "#334155",
            x: 0,
            opacity: 1,
            duration: 0.1,
            ease: "easeInOut",
          },
          0,
        );

        arrowAnimation.fromTo(
          caret.value,
          {
            color: "#10b981",
            x: -5,
            duration: 0.1,
          },
          {
            color: "#334155",
            x: 0,
            duration: 0.1,
          },
          0,
        );
      }
    },
  );
};
</script>
