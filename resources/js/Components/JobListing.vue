<template>
  <section class="bg-white rounded-lg border shadow-sm flex flex-col">
    <header class="border-b p-6 flex flex-col">
      <div class="flex items-center mb-2">
        <a target="_blank" class="group flex items-center" :href="listingInfo.listing_url">
          <img v-if="listingInfo.img_url" :src="listingInfo.img_url" alt="" class="h-6 w-6 object-contain rounded-md" />
          <img v-else src="/images/empty.png" class="h-6 w-6 object-contain" />
          <h5 class="ml-2">{{ listingInfo.company_name }}</h5>
          <Icon class="ml-1 w-4 h-4 text-slate-400 group-hover:text-teal-500" icon="heroicons-solid:external-link" />
        </a>
      </div>
      <article class="mb-2.5">
        <h4 class="truncate">
          {{ listingInfo.page_title }}
        </h4>
      </article>
      <section class="flex items-center flex-wrap gap-2">
        <div
          v-if="listingInfo.tags"
          v-for="tag in listingInfo.tags"
          :key="tag.id"
          class="px-2 text-[11px] py-1 rounded-md font-semibold"
          :class="colorVariants[tag.color]"
        >
          {{ tag.title }}
        </div>
      </section>
    </header>
    <main class="p-6 border-b flex flex-col gap-8">
      <div>
        <label class="card-label">Notes</label>
        <p :class="{ 'text-slate-500': !listingInfo.notes }">{{ listingInfo.notes ? listingInfo.notes : "No notes to show." }}</p>
      </div>
      <div class="flex gap-6 justify-between md:justify-normal">
        <article>
          <label class="card-label">Min Salary</label>
          <div class="flex items-center gap-1">
            <p class="font-medium" :class="{ 'text-slate-500 ': !listingInfo.salary_from }">
              {{ listingInfo.salary_from ? "€" + listingInfo.salary_from.toLocaleString("nl-NL") : "-" }}
            </p>
          </div>
        </article>
        <article class="">
          <label class="card-label text-right md:text-left">Max Salary</label>
          <div class="w-full text-right md:text-left">
            <p class="font-medium" :class="{ ' text-slate-500': !listingInfo.salary_to }">
              {{ listingInfo.salary_to ? "€" + listingInfo.salary_to.toLocaleString("nl-NL") : "-" }}
            </p>
          </div>
        </article>
      </div>
      <div class="flex flex-col md:flex-row flex-wrap gap-6">
        <article>
          <label class="card-label">Contact Name</label>
          <div class="flex items-center gap-1">
            <p class="" :class="{ 'text-slate-500 ': !listingInfo.contact_name }">
              {{ listingInfo.contact_name ? listingInfo.contact_name : "-" }}
            </p>
          </div>
        </article>
        <article>
          <label class="card-label">Contact Phone</label>
          <div class="flex items-center gap-1">
            <a v-if="listingInfo.contact_phone" :href="`tel:${listingInfo.contact_phone}`">{{ listingInfo.contact_phone }}</a>
            <p v-else class="text-slate-500">-</p>
          </div>
        </article>
        <article>
          <label class="card-label">Contact Email</label>
          <div class="flex items-center gap-1">
            <p v-if="!listingInfo.contact_email" class="font-medium" :class="{ ' text-slate-500': !listingInfo.contact_email }">-</p>
            <a :href="`mailto:${listingInfo.contact_email}`">{{ listingInfo.contact_email }}</a>
          </div>
        </article>
      </div>
    </main>
    <footer class="w-full p-6 flex items-center justify-between">
      <div class="flex items-center gap-1 card-label">
        <Icon class="w-5 h-5" icon="fluent:clock-12-regular" />
        <p>{{ "added " + dayjs(listingInfo.created_at).fromNow() }}</p>
      </div>
      <div class="flex items-center gap-2">
        <Link class="border rounded-md p-2" :href="'#'">
          <Icon icon="raphael:view" class="w-5 h-5" />
        </Link>
        <Link
          class="border rounded-md p-2.5 text-slate-500 hover:bg-red-50 hover:text-red-500 duration-150 transition-all hover:border-red-300"
          :href="route('job-listing.destroy', listingInfo.id)"
          method="delete"
          as="button"
        >
          <Icon icon="ion:trash" class="w-4 h-4" />
        </Link>
        <!-- <a target="_blank" :href="listingInfo.listing_url">Visit Listing Page</a> -->
      </div>
    </footer>
  </section>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { Link, router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
});

const deleteListing = (id) => {
  router.visit(route("job-listing.destroy", id));
};

const colorVariants = {
  amber: "bg-amber-100/60 text-amber-700/60",
  indigo: "bg-indigo-100/60 text-indigo-700/60",
  violet: "bg-violet-100/60 text-violet-700/60",
  emerald: "bg-emerald-100/60 text-emerald-700/60",
  purple: "bg-purple-100/60 text-purple-700/60",
  blue: "bg-blue-100/60 text-blue-700/60",
  red: "bg-red-100/60 text-red-700/60",
  lime: "bg-lime-100/60 text-lime-700/60",
  teal: "bg-teal-100/60 text-teal-700/60",
  rose: "bg-rose-100/60 text-rose-700/60",
};
</script>

<style lang="scss" scoped></style>
