<template>
  <ContentBox @click="showDetail" class="px-4 pt-4 pb-5 cursor-pointer hover:border-teal-400 sm:px-6 sm:pt-6 sm:pb-8">
    <header class="flex flex-col">
      <div class="flex items-center justify-between -mb-1">
        <button @click.stop="openLink" class="group flex items-center justify-start w-fit">
          <img
            v-if="listingInfo.img_url && !imageError"
            :src="listingInfo.img_url"
            alt=""
            class="h-6 w-6 object-contain rounded-md"
            @error="imageError = true"
          />
          <Icon v-else class="h-6 w-6 object-contain text-slate-600" icon="fluent:building-multiple-20-filled" />
          <span class="ml-2 truncate max-w-[180px] sm:max-w-sm">{{ listingInfo.company_name }} </span>

          <Icon class="ml-0.5 w-5 h-5 text-slate-400 group-hover:text-teal-500" icon="heroicons:arrow-up-right-16-solid" />
        </button>
        <button class="-mr-2">
          <Icon class="h-8 w-8 p-1.5 rounded-lg text-slate-500 hover:bg-slate-50 transition-all duration-100" icon="heroicons:trash" />
        </button>
      </div>

      <article class="flex flex-col gap-1 mt-4 mb-5">
        <h4 class="truncate">
          {{ listingInfo.page_title }}
        </h4>
        <section v-if="listingInfo.tags.length" class="flex items-center flex-wrap gap-2 mb-">
          <div>
            <TagListDisplay :tags="listingInfo.tags" />
          </div>
        </section>
      </article>

      <section class="flex gap-1.5 flex-col sm:gap-2 helper-text-sm sm:font-normal">
        <div v-if="listingInfo.location" class="flex gap-1 items-center">
          <Icon icon="fluent:location-12-regular" class="text-base text-slate-800" />
          <p v-if="listingInfo.location" class="">{{ listingInfo.location }}</p>
        </div>

        <div v-if="getSalaryRangeText()" class="flex gap-1 items-center">
          <Icon icon="fluent:money-hand-16-regular" class="text-base text-slate-800" />
          <p class="">{{ getSalaryRangeText() }}</p>
        </div>

        <div class="flex gap-1 items-center">
          <Icon icon="fluent:clock-12-regular" class="text-base text-slate-800" />
          <p>{{ "Added " + dayjs(listingInfo.created_at).fromNow() }}</p>
        </div>
      </section>
    </header>

    <main v-if="listingInfo.notes" class="flex flex-col mt-4">
      <div>
        <BaseLabel label="Notes" />
        <div v-if="listingInfo.notes" class="whitespace-pre-wrap" v-html="listingInfo.notes"></div>
        <p v-else class="text-slate-500">No notes to show</p>
      </div>
    </main>
  </ContentBox>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";

import { Icon } from "@iconify/vue";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { ref } from "vue";
import BaseLabel from "../UI/BaseLabel.vue";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
  tags: Array,
});

const openLink = () => {
  window.open(props.listingInfo.listing_url, "_blank");
};

const getSalaryRangeText = () => {
  if (props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `€${props.listingInfo.salary_from.toLocaleString("nl-NL")} - €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else if (!props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `up to €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};

const showDetail = () => {
  router.visit(route("job-listing.show", props.listingInfo.id));
};

const imageError = ref(false);
</script>
