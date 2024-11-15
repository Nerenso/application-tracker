<template>
  <MarketingPagesLayout class="landing-page">
    <Head title="Pricing" />
    <div class="mx-auto mt-24 w-full">
      <section class="mx-auto mb-24 w-full max-w-6xl px-5 xl:px-0">
        <div class="mb-12 flex w-full flex-col md:pb-6 md:pt-24 md:text-center">
          <h1
            class="mb-4 font-extrabold leading-none tracking-normal text-gray-900 md:tracking-tight"
          >
            Pricing
          </h1>
          <p
            class="mb-6 px-0 text-lg text-gray-500 md:mb-8 md:text-xl md:leading-8 lg:px-28"
          >
            We like to keep things simple and clear. Our pricing is
            straightforward and transparent, with no hidden fees or surprises.
          </p>
        </div>

        <UnderConstruction />

        <!-- <div class="mx-auto grid max-w-screen-md grid-cols-2">
          <article class="col-span-1 space-y-4 rounded-xl border bg-white p-6">
            <h5>FREE</h5>
            <p class="text-6xl font-bold">0</p>
          </article>
        </div> -->
      </section>
    </div>
  </MarketingPagesLayout>
</template>

<script setup>
import UnderConstruction from "@/Components/UI/UnderConstruction.vue";
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>
