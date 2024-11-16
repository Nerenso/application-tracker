<template>
  <MarketingPagesLayout class="landing-page">
    <Head title="Terms of Service" />
    <div class="mx-auto mt-32 w-full">
      <section class="mx-auto mb-24 w-full max-w-3xl px-5 xl:px-0">
        <h2>{{ termsOfService.title }}</h2>

        <div
          class="my-8"
          v-for="(section, i) in termsOfService.sections"
          :key="i"
        >
          <h4 class="mb-2">{{ section.title }}</h4>
          <p>{{ section.content }}</p>
        </div>
        <p class="w-full text-sm md:text-center">
          Last updated:
          <span class="italic">
            {{ termsOfService.lastUpdated }}
          </span>
        </p>
      </section>
    </div>
  </MarketingPagesLayout>
</template>

<script setup>
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
import { termsOfService } from "@/Utils/Marketing/SharedResources";
import { Head } from "@inertiajs/vue3";
</script>
