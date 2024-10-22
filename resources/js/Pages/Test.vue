<template>
  <main
    class="flex min-h-[200vh] w-full items-center justify-center bg-slate-50 p-4"
  >
    <div
      class="mx-auto grid w-full max-w-screen-lg grid-cols-1 gap-8 p-4 md:grid-cols-2 md:p-8"
    >
      <!-- <div
      class="w-full max-w-screen-sm space-y-6 rounded-2xl bg-white p-6 shadow-md"
    >
      <h4>Hello from Test</h4>
      <p>{{ message }}</p>

      <div v-if="company_name">{{ company_name }}</div>
      <div v-if="coverLetter" class="whitespace-pre-line" v-html="coverLetter"></div>
      <div v-else>
        <XSpinner />
      </div>
      <XInput
        type="number"
        label="Listing ID"
        class="w-full"
        v-model="listingIdInput"
      />
      <XButton @click="handleCheck" color="primary">Check</XButton>
    </div> -->

      <section
        ref="block"
        @mouseenter="cardAnimation.play(), blobAnimations.play()"
        @mouseleave="cardAnimation.reverse(), blobAnimations.pause()"
        class="group/card flex w-full cursor-pointer flex-col overflow-hidden rounded-xl bg-white p-1 shadow-lg"
      >
        <div
          ref="cardImageWrapper"
          class="relative h-[21rem] w-full overflow-hidden rounded-lg bg-slate-100"
        >
          <section class="relative w-full">
            <!-- <div
              class="absolute z-10 h-[400px] w-full saturate-0 backdrop-blur-2xl transition-all duration-200 group-hover/card:saturate-100"
            /> -->
            <div
              ref="blob1"
              class="absolute right-60 top-10 h-40 w-40 rounded-full bg-teal-300/30 blur-xl saturate-0 transition-all duration-200 group-hover/card:saturate-100"
            />
            <div
              ref="blob2"
              class="absolute right-20 top-24 h-64 w-72 rounded-full bg-emerald-100 blur-2xl saturate-0 transition-all duration-200 group-hover/card:saturate-100"
            />
          </section>
          <div
            class="absolute z-30 h-full w-full bg-gradient-to-b from-transparent to-slate-600/5"
          />
          <img
            ref="cardImage"
            src="/images/CoverLetterConfig.png"
            class="absolute -bottom-3 -right-3 z-20 w-[325px] rounded-lg"
            alt=""
          />
        </div>
        <div class="p-6">
          <h3>Personalized Cover Letters</h3>
          <p class="mt-4">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo ut
            pariatur impedit, laudantium reprehenderit ea dicta, assumenda
            accusamus aliquid facere praesentium nostrum ex veniam perferendis.
            Deserunt ad quam recusandae dolores. Ipsa vitae alias molestiae
          </p>
          <div ref="text1" class="leading hidden sm:block">
            <ArrowButton>Get Personalized Cover Letters</ArrowButton>
          </div>
          <div class="leading-9 sm:hidden">
            <ArrowButton>Get Personalized Cover Letters</ArrowButton>
          </div>
        </div>
      </section>

      <AnimatedFeatureCard />

      <!-- <section
        @mouseenter="blobAnimations.play()"
        @mouseleave="blobAnimations.pause()"
        class="relative w-full border border-slate-600"
      >
        <div
          ref="blob1"
          class="absolute right-60 top-10 h-40 w-40 rounded-full bg-teal-500"
        />
        <div
          ref="blob2"
          class="absolute right-20 top-24 h-64 w-72 rounded-full bg-emerald-200"
        />
        <div class="absolute h-full w-full bg-slate-300/10 backdrop-blur-2xl" />
      </section> -->
    </div>
  </main>
</template>

<script setup>
import { XButton, XInput, XSpinner } from "@indielayer/ui";
import { gsap } from "gsap";
import { router } from "@inertiajs/vue3";
import { onBeforeUnmount } from "vue";
import { onMounted } from "vue";
import { ref } from "vue";
import { Icon } from "@iconify/vue";
import ArrowButton from "@/Components/Marketing/Base/ArrowButton.vue";
import AnimatedFeatureCard from "@/Components/Marketing/Base/AnimatedFeatureCard.vue";
const props = defineProps({
  message: String,
  jobListing: Object,
});

const listingIdInput = ref("");
const company_name = ref("");
const coverLetter = ref("");

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
            y: "2rem",
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
