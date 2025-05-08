<template>
  <ContentBox
    class="cursor-pointer px-4 pb-5 pt-4 hover:border-teal-400 sm:px-6 sm:pb-8 sm:pt-6"
  >
    <header class="flex flex-col">
      <div class="-mb-1 flex items-center justify-between">
        <button
          @click.stop="openLink"
          class="group flex w-fit items-center justify-start"
        >
          <img
            v-if="listingInfo.img_url && !imageError"
            :src="listingInfo.img_url"
            alt=""
            class="h-6 w-6 rounded-md object-contain"
            @error="imageError = true"
          />
          <Icon
            v-else
            class="h-6 w-6 object-contain text-slate-600"
            icon="fluent:building-multiple-20-filled"
          />
          <span class="ml-2 max-w-[180px] truncate sm:max-w-sm"
            >{{ listingInfo.company_name }}
          </span>

          <Icon
            class="ml-0.5 h-5 w-5 text-slate-400 group-hover:text-teal-500"
            icon="heroicons:arrow-up-right-16-solid"
          />
        </button>

        <ListingActionMenu
          :listing="listingInfo"
          class="-mr-2"
          @delete="handleDelete"
        />
      </div>

      <article class="mb-5 mt-4 flex flex-col gap-2">
        <h4 class="truncate">
          {{ listingInfo.page_title }}
        </h4>
        <section
          v-if="listingInfo.tags.length"
          class="mb- flex flex-wrap items-center gap-2"
        >
          <div>
            <TagListDisplay :tags="listingInfo.tags" />
          </div>
        </section>
      </article>

      <section
        class="helper-text-sm flex flex-col gap-1.5 sm:gap-2 sm:font-normal"
      >
        <div v-if="listingInfo.location" class="flex items-center gap-1">
          <Icon
            icon="fluent:location-12-regular"
            class="text-base text-slate-800"
          />
          <p v-if="listingInfo.location" class="">
            {{ listingInfo.location }}
          </p>
        </div>

        <div v-if="getSalaryRangeText()" class="flex items-center gap-1">
          <Icon
            icon="fluent:money-hand-16-regular"
            class="text-base text-slate-800"
          />
          <p class="">{{ getSalaryRangeText() }}</p>
        </div>

        <ListingStatus :listing="listingInfo" />
      </section>
    </header>

    <main v-if="listingInfo.notes" class="mt-4 flex flex-col">
      <div>
        <BaseLabel label="Notes" />
        <div
          v-if="listingInfo.notes"
          class="whitespace-pre-wrap"
          v-html="listingInfo.notes"
        ></div>
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
import BaseIconButton from "../UI/BaseIconButton.vue";
import { onMounted } from "vue";
import BaseActionMenu from "../UI/BaseActionMenu.vue";
import ListingActionMenu from "@/Components/JobListing/ListingActionMenu.vue";
import ListingStatus from "@/Components/JobListing/ListingStatus.vue";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
  tags: Array,
});

let echoChannel;

onMounted(() => {
  if (!props.listingInfo.structured_listing) {
    echoChannel = Echo.private(
      `job-listings.${props.listingInfo.id}.summarize-listing`,
    );
    echoChannel.listen("SummarizeListingJobFinished", (e) => {
      echoChannel.stopListening("SummarizeListingJobFinished");
      router.reload({ preserveScroll: true });
    });
  }
});

const openLink = () => {
  window.open(props.listingInfo.listing_url, "_blank");
};

const getSalaryRangeText = () => {
  if (props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `€${props.listingInfo.salary_from.toLocaleString("nl-NL")} - €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else if (!props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `up to €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else if (props.listingInfo.salary_from && !props.listingInfo.salary_to) {
    return `starting from €${props.listingInfo.salary_from.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};

const handleDelete = () => {
  router.delete(route("job-listing.destroy", props.listingInfo.id));
};

const imageError = ref(false);
</script>
