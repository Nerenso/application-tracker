<template>
  <section
    ref="block"
    @mouseenter="cardAnimation.play(), blobAnimations.play()"
    @mouseleave="cardAnimation.reverse(), blobAnimations.pause()"
    class="group/card flex w-full flex-col overflow-hidden rounded-2xl bg-white p-1 shadow-[0_30px_40px_-25px_rgba(0,0,0,0.25)]"
  >
    <div
      ref="cardImageWrapper"
      class="relative h-[21rem] w-full overflow-hidden rounded-xl bg-slate-100"
    >
      <section class="relative w-full">
        <img
          ref="blob1"
          src="/images/blob1.png"
          class="absolute -top-28 right-4 h-[500px] w-[500px] opacity-0 saturate-0 transition-all duration-200 group-hover/card:opacity-30 group-hover/card:saturate-100"
        />
        <img
          src="/images/blob2.png"
          ref="blob2"
          class="absolute -right-4 -top-16 h-[500px] w-[500px] opacity-0 saturate-0 transition-all duration-200 group-hover/card:opacity-30 group-hover/card:saturate-100"
        />
      </section>
      <div
        class="absolute z-30 h-full w-full bg-gradient-to-b from-transparent to-slate-600/5"
      />
      <div ref="cardImage" class="relative h-full w-full">
        <slot name="image"></slot>
      </div>
    </div>
    <div class="p-4 sm:p-6">
      <slot name="header">
        <h3>Personalized Cover Letters</h3>
      </slot>

      <slot name="description">
        <p class="mt-4">
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo ut
          pariatur impedit, laudantium reprehenderit ea dicta, assumenda
          accusamus aliquid facere praesentium nostrum ex veniam perferendis.
          Deserunt ad quam recusandae dolores. Ipsa vitae alias molestiae
        </p>
      </slot>
      <div ref="text1" class="leading ml-2 hidden sm:block">
        <ArrowButton @click="emits('buttonClicked')">{{
          buttonText
        }}</ArrowButton>
      </div>
      <div class="mt-4 px-2 leading-9 sm:hidden">
        <ArrowButton @click="emits('buttonClicked')">{{
          buttonText
        }}</ArrowButton>
      </div>
    </div>
  </section>
</template>

<script setup>
import { gsap } from "gsap";
import { router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { Icon } from "@iconify/vue";
import ArrowButton from "./ArrowButton.vue";

const props = defineProps({
  buttonText: String,
});

const emits = defineEmits(["buttonClicked"]);

const block = ref(null);
const text1 = ref(null);
const cardImageWrapper = ref(null);
const cardImage = ref(null);

const blob1 = ref(null);
const blob2 = ref(null);

const cardAnimation = gsap.timeline({
  paused: true,
});

const blobAnimations = gsap.timeline({
  paused: true,
});

onMounted(() => {
  handleCardAnimationTL();
  handleBlobAnimations();
});

const handleCheck = () => {
  company_name.value = null;
  router.visit(route("test", { listingId: listingIdInput.value }));
};

const handleCardAnimationTL = () => {
  let responsiveAnimations = gsap.matchMedia();

  responsiveAnimations.add(
    {
      isMobile: "(max-width: 640px)",
      isDesktop: "(min-width: 640px)",
    },
    (context) => {
      let { isMobile, isDesktop } = context.conditions;

      if (isDesktop) {
        cardAnimation.fromTo(
          text1.value,
          {
            height: 0,
            y: 10,
            duration: 0.2,
            opacity: 0,
            marginTop: 0,
          },
          {
            height: "2rem",
            y: 0,
            duration: 0.2,
            opacity: 1,
            marginTop: "1rem",
          },
          0,
        );

        cardAnimation.fromTo(
          cardImageWrapper.value,
          {
            height: "21rem",
            duration: 0.2,
          },
          {
            height: "18rem",
            duration: 0.2,
          },
          0,
        );

        cardAnimation.to(
          cardImage.value,
          {
            y: 25,
            duration: 0.2,
          },
          0,
        );
      }
    },
  );
};

const handleBlobAnimations = () => {
  blobAnimations.fromTo(
    blob1.value,
    {
      x: "-20%",
      ease: "none",
    },
    {
      x: "20%",
      repeat: -1,
      yoyo: true,
      duration: 5,
      ease: "none",
    },
    0,
  );

  blobAnimations.fromTo(
    blob2.value,
    {
      x: "25%",
      y: "-20%",
      ease: "none",
    },
    {
      x: "-20%",
      y: "30%",
      repeat: -1,
      yoyo: true,
      duration: 5,
      ease: "none",
    },
    0,
  );
};
</script>
