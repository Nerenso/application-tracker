<template>
  <AnimatedFeatureCard
    class="h-fit"
    button-text="Get Cover Letters"
    @button-clicked="router.visit(route('register'))"
  >
    <template #image>
      <img
        src="/images/CoverLetterConfig.png"
        class="absolute -bottom-3 -left-2 z-20 w-[325px] rounded-lg"
        alt="cover letter configuration settings"
      />
    </template>
    <template #header>
      <header
        class="flex w-full flex-col items-start gap-2 p-2 sm:flex-row sm:items-center"
      >
        <Icon
          icon="solar:letter-opened-bold-duotone"
          class="h-7 w-7 text-teal-400"
        />
        <h4>Personalized Cover Letters</h4>
      </header>
    </template>

    <template #description>
      <section class="mt-2 p-2 text-base leading-7 text-slate-600 md:text-lg">
        <p>
          Compelling cover letters that highlight why you're the ideal
          candidate, by taking into account your work-experience, education,
          motivation and skillset.
        </p>
      </section>
    </template>
  </AnimatedFeatureCard>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import AnimatedFeatureCard from "../Base/AnimatedFeatureCard.vue";
import { router } from "@inertiajs/vue3";
</script>
