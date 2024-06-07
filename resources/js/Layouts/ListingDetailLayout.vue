<template>
  <Head :title="listing.page_title" />
  <DashboardLayout title="Listing Details" :show-top-bar="false">
    <section class="w-full px-2 py-8 pt-6 flex flex-col gap-6">
      <div class="max-w-5xl mx-auto w-full">
        <XBreadcrumbs :items="crumbs" color="secondary" />
      </div>

      <div class="max-w-5xl mx-auto w-full">
        <ListingDetailNav :listing="listing" />
      </div>

      <div class="detail-page max-w-5xl mx-auto w-full bg-white border rounded-lg">
        <header class="px-4 pt-4 sm:px-6 sm:pt-6">
          <div class="flex items-center my-2">
            <a target="_blank" class="group flex items-center" :href="listing.listing_url">
              <img
                v-if="listing.img_url && !imgError"
                :src="listing.img_url"
                alt=""
                class="h-6 w-6 object-contain rounded-md"
                @error="imgError = true"
              />
              <Icon v-else class="h-6 w-6 object-contain text-slate-600" icon="fluent:building-multiple-20-filled" />
              <span class="ml-2 truncate max-w-[180px] sm:max-w-sm">{{ listing.company_name }}</span>
              <Icon class="ml-0.5 w-5 h-5 text-slate-400 group-hover:text-teal-500" icon="heroicons:arrow-up-right-16-solid" />
            </a>
          </div>
          <h2>
            {{ listing.page_title }}
          </h2>

          <div class="flex items-center justify-between">
            <TagListDisplay v-if="listing.tags.length" :tags="listing.tags" class="mt-2" />
            <p v-else class="text-slate-500 mt-2">No Tags Added</p>
            <button @click="handleTagDropDown" class="w-10 pl-[21px] pt-1.5 h-6">
              <Icon icon="fluent:chevron-down-16-regular" :class="showTagDropDown ? 'rotate-180' : ''" class="transition-all duration-150 h-5 w-5" />
            </button>
          </div>
          <div class="relative" :class="showTagDropDown ? 'extended' : 'shrunk'">
            <div class="w-full max-w-5xl overflow-hidden">
              <div class="my-4 flex items-center justify-between w-full">
                <label class="font-medium">Tags</label>

                <AddTagWidget :class="showTagDropDown ? 'absolute top-5 right-0 z-20' : ''" />
              </div>
              <div class="flex items-center gap-x-1.5 gap-y-2 flex-wrap">
                <div v-for="tag in tags" :key="tag.id">
                  <div
                    v-if="!tagForm.selectedTags.includes(tag.id)"
                    @click="addToSelected(tag.id)"
                    class="px-2.5 text-xs py-1.5 rounded-md cursor-pointer font-semibold"
                    :class="colorVariants[tag.color]"
                  >
                    <p>{{ tag.title }}</p>
                  </div>
                  <div
                    v-if="tagForm.selectedTags.includes(tag.id)"
                    @click="removeFromSelected(tag.id)"
                    class="px-2.5 text-xs py-1.5 font-semibold cursor-pointer rounded-md text-white"
                    :class="selectedColorVariants[tag.color]"
                  >
                    <p>{{ tag.title }}</p>
                  </div>
                </div>

                <div
                  v-if="!tags.length"
                  class="flex items-center justify-center p-6 border w-full text-sm text-slate-500 border-slate-300 border-dashed rounded-lg"
                >
                  <p>You haven't added any tags yet, click on the 'plus' icon to add tags.</p>
                </div>
              </div>
            </div>
          </div>
        </header>
        <article class="px-4 pb-4 sm:px-6 sm:pb-6">
          <!-- <div v-if="props.listing.generated_description" class="whitespace-pre-line" v-html="formattedDescription" /> -->

          <CollapsableListing v-if="listing.structured_listing" :job_listing="job_listing" :listing_language="listing.listing_language" />

          <div v-else class="mx-auto max-w-2xl flex flex-col items-center justify-center p-6 mb-8">
            <dotlottie-player src="/lottie/AI2.lottie" :autoplay.attr="true" :loop.attr="true" />
            <div class="text-center max-w-xs md:text-lg">
              <span class="block text-lg md:text-xl font-medium"> Working on it! </span>
              Check back in a few minutes.
            </div>
          </div>
        </article>
      </div>
      <slot></slot>
    </section>
  </DashboardLayout>
</template>

<script setup>
import "@dotlottie/player-component";
import { XBreadcrumbs, XButton } from "@indielayer/ui";
import { getFormattedDescription } from "@/Utils/DescriptionFormatter";
import { Icon } from "@iconify/vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { selectedColorVariants, colorVariants } from "@/Utils/TagColors";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";
import AddTagWidget from "@/Components/Tags/AddTagWidget.vue";
import { onMounted } from "vue";
import CollapsableListing from "@/Components/JobListing/CollapsableListing.vue";
import ListingDetailNav from "@/Components/JobListing/ListingDetailNav.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
});

const imgError = ref(false);
const { job_listing } = props.listing.structured_listing ? JSON.parse(props.listing.structured_listing) : {};

const tagForm = useForm({
  selectedTags: [],
});

onMounted(() => {
  syncTagsWithDBValues();
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
    const newArray = [...tagForm.selectedTags].filter((element) => element !== item);
    tagForm.selectedTags = newArray;
  }
};

const formattedDescription = ref("");

if (props.listing.generated_description) {
  formattedDescription.value = getFormattedDescription(props.listing.generated_description);
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

console.log("rendered");
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
