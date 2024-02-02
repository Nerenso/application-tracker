<template>
  <ContentBox>
    <header class="border-b p-6 flex flex-col">
      <div class="flex items-center mb-2">
        <a target="_blank" class="group flex items-center" :href="listingInfo.listing_url">
          <img v-if="listingInfo.img_url" :src="listingInfo.img_url" alt="" class="h-6 w-6 object-contain rounded-md" />
          <img v-else src="/images/empty.png" class="h-6 w-6 object-contain" />
          <h5 class="ml-2">{{ listingInfo.company_name }}</h5>
          <Icon class="ml-0.5 w-5 h-5 text-slate-400 group-hover:text-teal-500" icon="heroicons:arrow-up-right-16-solid" />
        </a>
      </div>
      <article class="mb-2.5">
        <h4 class="truncate">
          {{ listingInfo.page_title }}
        </h4>
      </article>
      <section class="flex items-center flex-wrap gap-2">
        <TagListDisplay :tags="listingInfo.tags" />
      </section>
    </header>
    <main class="p-6 border-b flex flex-col gap-8">
      <div>
        <label class="card-label">Notes</label>
        <p :class="{ 'text-slate-500': !listingInfo.notes }">{{ listingInfo.notes ?? "No notes to show." }}</p>
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
              {{ listingInfo.contact_name ?? "-" }}
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
        <p>{{ "Added " + dayjs(listingInfo.created_at).fromNow() }}</p>
      </div>
      <div class="flex items-center gap-2">
        <Link :href="route('job-listing.show', listingInfo.id)" class="border rounded-md p-2">
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
      </div>
    </footer>
  </ContentBox>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
});
</script>
