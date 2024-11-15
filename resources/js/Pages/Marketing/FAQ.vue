<template>
  <MarketingPagesLayout class="landing-page">
    <Head title="FAQ" />
    <div class="mx-auto mt-24 w-full">
      <section class="mx-auto mb-24 w-full max-w-6xl px-5 xl:px-0">
        <div class="mb-12 flex w-full flex-col md:pb-6 md:pt-24 md:text-center">
          <h1
            class="mb-4 font-extrabold leading-none tracking-normal text-gray-900 md:tracking-tight"
          >
            Got Questions?
          </h1>
          <p
            class="mb-6 px-0 text-lg text-gray-500 md:mb-8 md:text-xl md:leading-8 lg:px-28"
          >
            We have answers! Here we address your most common inquiries and
            provide you with the information you need to succeed. Dive in and
            explore our answers. If you don’t find what you’re looking for, feel
            free to reach out to us directly!
          </p>
        </div>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
          <FaqCard
            v-for="(item, i) in faq"
            :key="i"
            :question="item.question"
            :answer="item.answer"
          />
        </div>
      </section>
    </div>
  </MarketingPagesLayout>
</template>

<script setup>
import FaqCard from "@/Components/Marketing/Elements/FaqCard.vue";
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
import { faq } from "@/Utils/Marketing/SharedResources.js";
import { Head } from "@inertiajs/vue3";
</script>
