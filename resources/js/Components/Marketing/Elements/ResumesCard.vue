<template>
  <AnimatedFeatureCard class="mt-48 h-fit" button-text="Get Tailored Resumes">
    <template #image>
      <img
        src="/images/resume.png"
        class="absolute -inset-x-0 -bottom-32 z-20 m-auto w-[310px] rounded-lg"
        alt="resume illustration"
      />
    </template>
    <template #header>
      <header
        class="flex w-full flex-col items-start gap-2 p-2 sm:flex-row sm:items-center"
      >
        <Icon
          icon="solar:documents-bold-duotone"
          class="h-7 w-7 text-teal-400"
        />
        <h4>Tailored Resumes</h4>
      </header>
    </template>

    <template #description>
      <section class="mt-2 p-2 text-base leading-7 text-slate-600 md:text-lg">
        <p>
          Highlight relevant skills and experiences specific to the job listing,
          increasing your chances of catching the hiring manager's eye. All
          while being ATS friendly.
        </p>
      </section>
    </template>
  </AnimatedFeatureCard>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import AnimatedFeatureCard from "../Base/AnimatedFeatureCard.vue";
</script>
