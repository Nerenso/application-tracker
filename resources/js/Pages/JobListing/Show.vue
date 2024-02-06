<template>
  <Head :title="listing.page_title" />
  <DashboardLayout title="Listing Details">
    <section class="detail-page w-full px-2 py-8 pt-6 flex flex-col gap-6">
      <div class="max-w-5xl mx-auto w-full pl-3">
        <XBreadcrumbs :items="crumbs" color="secondary" />
      </div>
      <div class="max-w-5xl mx-auto w-full bg-white p-4 md:p-6 border rounded-lg">
        <div class="flex items-center my-2">
          <a target="_blank" class="group flex items-center" :href="listing.listing_url">
            <img v-if="listing.img_url" :src="listing.img_url" alt="" class="h-6 w-6 object-contain rounded-md" />
            <img v-else src="/images/empty.png" class="h-6 w-6 object-contain" />
            <h5 class="ml-2">{{ listing.company_name }}</h5>
            <Icon class="ml-0.5 w-5 h-5 text-slate-400 group-hover:text-teal-500" icon="heroicons:arrow-up-right-16-solid" />
          </a>
        </div>
        <h2>
          {{ listing.page_title }}
        </h2>

        <TagListDisplay :tags="listing.tags" class="mt-2" />

        <div v-if="props.listing.generated_description" class="whitespace-pre-line" v-html="formattedDescription" />
        <div v-else class="mx-auto max-w-2xl flex flex-col items-center justify-center p-6">
          <dotlottie-player src="/lottie/AI2.lottie" :autoplay.attr="true" :loop.attr="true" />
          <div class="text-center max-w-xs md:text-lg">
            <span class="block text-lg md:text-xl font-medium"> Working on it! </span>
            Check back in a few minutes.
          </div>
        </div>
      </div>

      <ContentBox class="centered-container">
        <main class="p-6 border-b flex flex-col gap-8">
          <h4 class="">Listing Information</h4>
          <div>
            <label class="card-label">Notes</label>
            <p :class="{ 'text-slate-500': !listing.notes }">{{ listing.notes ?? "No notes to show." }}</p>
          </div>
          <div class="flex gap-6 justify-between md:justify-normal">
            <article>
              <label class="card-label">Min Salary</label>
              <div class="flex items-center gap-1">
                <p class="font-medium" :class="{ 'text-slate-500 ': !listing.salary_from }">
                  {{ listing.salary_from ? "€" + listing.salary_from.toLocaleString("nl-NL") : "-" }}
                </p>
              </div>
            </article>
            <article class="">
              <label class="card-label text-right md:text-left">Max Salary</label>
              <div class="w-full text-right md:text-left">
                <p class="font-medium" :class="{ ' text-slate-500': !listing.salary_to }">
                  {{ listing.salary_to ? "€" + listing.salary_to.toLocaleString("nl-NL") : "-" }}
                </p>
              </div>
            </article>
          </div>
          <div class="flex flex-col md:flex-row flex-wrap gap-6">
            <article>
              <label class="card-label">Contact Name</label>
              <div class="flex items-center gap-1">
                <p class="" :class="{ 'text-slate-500 ': !listing.contact_name }">
                  {{ listing.contact_name ?? "-" }}
                </p>
              </div>
            </article>
            <article>
              <label class="card-label">Contact Phone</label>
              <div class="flex items-center gap-1">
                <a v-if="listing.contact_phone" :href="`tel:${listing.contact_phone}`">{{ listing.contact_phone }}</a>
                <p v-else class="text-slate-500">-</p>
              </div>
            </article>
            <article>
              <label class="card-label">Contact Email</label>
              <div class="flex items-center gap-1">
                <p v-if="!listing.contact_email" class="font-medium" :class="{ ' text-slate-500': !listing.contact_email }">-</p>
                <a :href="`mailto:${listing.contact_email}`">{{ listing.contact_email }}</a>
              </div>
            </article>
          </div>
        </main>
      </ContentBox>
    </section>
  </DashboardLayout>
</template>

<script setup>
import "@dotlottie/player-component";
import { XBreadcrumbs } from "@indielayer/ui";
import { getFormattedDescription } from "@/Utils/DescriptionFormatter";
import { Icon } from "@iconify/vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";

import ContentBox from "@/Components/UI/ContentBox.vue";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";

const props = defineProps({
  listing: Object,
});

const crumbs = [
  { href: route("job-listing.index"), label: "Saved Listings" },
  { to: "#", label: props.listing.page_title },
];

const formattedDescription = ref("");

if (props.listing.generated_description) {
  formattedDescription.value = getFormattedDescription(props.listing.generated_description);
}
</script>
