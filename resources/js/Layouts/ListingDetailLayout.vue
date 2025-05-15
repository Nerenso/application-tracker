<template>
  <Head :title="listing.page_title" />
  <DashboardLayout
    title="Listing Details"
    :show-top-bar="false"
    :sub-title="`/ ${listingStore.state.activeTab}`"
  >
    <section class="flex w-full flex-col px-2 py-8 pb-32 pt-6 sm:px-5">
      <div class="mx-auto mb-4 w-full max-w-5xl pl-0.5 text-sm">
        <XBreadcrumbs :items="crumbs" color="secondary" />
      </div>

      <div class="mx-auto w-full max-w-5xl md:mb-8">
        <ListingDetailNav :listing="listing" />
      </div>

      <div
        class="detail-page mx-auto mb-6 w-full max-w-5xl rounded-lg border bg-white"
      >
        <header class="px-4 pt-4 sm:px-6 sm:pt-6">
          <div class="mb-2 flex items-center justify-between">
            <a
              target="_blank"
              class="group flex items-center"
              :href="listing.listing_url"
            >
              <img
                v-if="listing.img_url && !imgError"
                :src="listing.img_url"
                alt=""
                class="h-6 w-6 rounded-md object-contain"
                @error="imgError = true"
              />
              <Icon
                v-else
                class="h-6 w-6 object-contain text-slate-600"
                icon="fluent:building-multiple-20-filled"
              />
              <span class="ml-2 max-w-[180px] truncate sm:max-w-sm">{{
                listing.company_name
              }}</span>
              <Icon
                class="ml-0.5 h-5 w-5 text-slate-400 group-hover:text-teal-500"
                icon="heroicons:arrow-up-right-16-solid"
              />
            </a>
            <ListingActionMenu
              :listing="listing"
              class="-mr-2"
              @delete="handleDelete"
            />
          </div>

          <h2>
            {{ listing.page_title }}
          </h2>

          <div class="flex items-center justify-between">
            <TagListDisplay
              v-if="listing.tags.length"
              :tags="listing.tags"
              class="mt-2"
            />
            <p v-else class="mt-2 text-slate-500">No Tags Added</p>
            <button
              @click="handleTagDropDown"
              class="h-6 w-10 pl-[21px] pt-1.5"
            >
              <Icon
                icon="fluent:chevron-down-16-regular"
                :class="showTagDropDown ? 'rotate-180' : ''"
                class="h-5 w-5 transition-all duration-150"
              />
            </button>
          </div>
          <div
            class="relative"
            :class="showTagDropDown ? 'extended' : 'shrunk'"
          >
            <div class="w-full max-w-5xl overflow-hidden">
              <div class="my-4 flex w-full items-center justify-between">
                <label class="font-medium">Tags</label>

                <AddTagWidget
                  :class="showTagDropDown ? 'absolute right-0 top-5 z-20' : ''"
                />
              </div>
              <div class="flex flex-wrap items-center gap-x-1.5 gap-y-2">
                <div v-for="tag in tags" :key="tag.id">
                  <div
                    v-if="!tagForm.selectedTags.includes(tag.id)"
                    @click="addToSelected(tag.id)"
                    class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold"
                    :class="colorVariants[tag.color]"
                  >
                    <p>{{ tag.title }}</p>
                  </div>
                  <div
                    v-if="tagForm.selectedTags.includes(tag.id)"
                    @click="removeFromSelected(tag.id)"
                    class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold text-white"
                    :class="selectedColorVariants[tag.color]"
                  >
                    <p>{{ tag.title }}</p>
                  </div>
                </div>

                <div
                  v-if="!tags.length"
                  class="flex w-full items-center justify-center rounded-lg border border-dashed border-slate-300 p-6 text-sm text-slate-500"
                >
                  <p>
                    You haven't added any tags yet, click on the 'plus' icon to
                    add tags.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </header>

        <article class="overflow-x-visible px-4 sm:px-6">
          <CollapsableListing
            v-if="listing.structured_listing"
            :job_listing="job_listing"
            :listing_language="listing.listing_language"
          />

          <LoadingGraphic v-else />
        </article>
        <ListingMetaData :listing="listing" class="mt-8 px-4 sm:px-6" />
        <ListingStatus
          :listing="listing"
          :on-detail-page="true"
          class="mt-4 px-4 pb-4 sm:px-6 sm:pb-6"
        />
      </div>

      <div class="">
        <slot></slot>
      </div>
    </section>
  </DashboardLayout>
</template>

<script setup>
import "@dotlottie/player-component";
import { XBreadcrumbs, XButton } from "@indielayer/ui";
import { getFormattedDescription } from "@/Utils/DescriptionFormatter";
import { Icon } from "@iconify/vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { selectedColorVariants, colorVariants } from "@/Utils/TagColors";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";
import AddTagWidget from "@/Components/Tags/AddTagWidget.vue";
import { onMounted, ref } from "vue";
import CollapsableListing from "@/Components/JobListing/CollapsableListing.vue";
import ListingDetailNav from "@/Components/JobListing/ListingDetailNav.vue";
import LoadingGraphic from "@/Components/UI/LoadingGraphic.vue";
import { useListingDetailStore } from "@/State/ListingDetailStore";
import ListingActionMenu from "@/Components/JobListing/ListingActionMenu.vue";
import ListingMetaData from "@/Components/JobListing/ListingMetaData.vue";
import ListingStatus from "@/Components/JobListing/ListingStatus.vue";
import { useUIStore } from "@/State/UIStore";

const props = defineProps({
  listing: Object,
  tags: Array,
});

let echoChannel;

const listingStore = useListingDetailStore();
const uiStore = useUIStore();

onMounted(() => {
  uiStore.actions.setSelectedListingID(props.listing.id);
});

const imgError = ref(false);
const { job_listing } = props.listing.structured_listing
  ? JSON.parse(props.listing.structured_listing)
  : {};

const tagForm = useForm({
  selectedTags: [],
});

onMounted(() => {
  syncTagsWithDBValues();

  if (!props.listing.structured_listing) {
    echoChannel = Echo.private(
      `job-listings.${props.listing.id}.summarize-listing`,
    );

    echoChannel.listen("SummarizeListingJobFinished", (e) => {
      echoChannel.stopListening("SummarizeListingJobFinished");
      router.visit(route("listing-detail.timeline", props.listing.id), {});
    });
  }
});

const showTagDropDown = ref(false);

const syncTagsWithDBValues = () => {
  tagForm.selectedTags = props.listing.tags.map((item) => {
    return item.id;
  });
};

const crumbs = [
  { href: route("job-listing.index"), label: "Saved Listings" },
  { to: "#", label: props.listing.page_title },
];

const addToSelected = (item) => {
  const foundItem = tagForm.selectedTags.includes(item);
  if (!foundItem) {
    tagForm.selectedTags.push(item);
  }
};

const removeFromSelected = (item) => {
  const foundItem = tagForm.selectedTags.includes(item);
  if (foundItem) {
    const newArray = [...tagForm.selectedTags].filter(
      (element) => element !== item,
    );
    tagForm.selectedTags = newArray;
  }
};

const formattedDescription = ref("");

if (props.listing.generated_description) {
  formattedDescription.value = getFormattedDescription(
    props.listing.generated_description,
  );
}

const syncTags = () => {
  tagForm.post(route("job-listing.syncTags", props.listing.id), {
    onSuccess: () => {
      showTagDropDown.value = false;
    },
    preserveScroll: true,
  });
};

const handleTagDropDown = () => {
  if (showTagDropDown.value) {
    syncTags();
    showTagDropDown.value = false;
  } else {
    showTagDropDown.value = true;
  }
};

const handleDelete = () => {
  router.visit(route("job-listing.destroy", props.listing.id), {
    method: "delete",
    data: {
      origin: "listing-detail",
    },
    onSuccess: () => {
      router.visit(route("job-listing.index"));
    },
  });
};
</script>

<style>
.shrunk {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 200ms;
}

.extended {
  display: grid;
  transition: grid-template-rows 200ms;
  grid-template-rows: 1fr;
}
</style>
