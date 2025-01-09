<template>
  <KeepAlive>
    <section class="relative">
      <div class="mt-4">
        <p :class="showListingDropDown ? 'line-clamp-none' : 'line-clamp-2'">
          {{ job_listing.job_description }}
        </p>
      </div>
      <article :class="showListingDropDown ? 'extended' : 'shrunk'">
        <div class="mb-4 overflow-y-hidden">
          <div>
            <h3>
              {{
                listing_language == "nl"
                  ? "Bedrijfsinformatie"
                  : "Company Information"
              }}
            </h3>
            <p>{{ job_listing.company_information }}</p>
          </div>

          <div>
            <h3>
              {{ listing_language == "nl" ? "Vereisten" : "Requirements" }}
            </h3>
            <ul class="ml-5 list-disc space-y-1 sm:ml-4">
              <li v-for="(requirement, i) in job_listing.requirements" :key="i">
                {{ requirement }}
              </li>
            </ul>
          </div>

          <div>
            <h3>
              {{
                listing_language == "nl" ? "Wat Ze Bieden" : "What They Offer"
              }}
            </h3>
            <ul class="ml-5 list-disc space-y-1 sm:ml-4">
              <li v-for="(offer, i) in job_listing.what_they_offer" :key="i">
                {{ offer }}
              </li>
            </ul>
          </div>

          <div>
            <h3>
              {{
                listing_language == "nl"
                  ? "Overige Informatie"
                  : "Additional Information"
              }}
            </h3>
            <ul class="ml-5 list-disc space-y-1 sm:ml-4">
              <li v-for="(detail, i) in job_listing.important_details" :key="i">
                {{ detail }}
              </li>
            </ul>
          </div>
        </div>
      </article>

      <button
        class="flex items-center justify-between gap-1 rounded-md border bg-white px-3 py-2"
        size="sm"
        @click="handleListingDropDown"
      >
        <span class="text-sm font-medium">
          {{ showListingDropDown ? "Show Less" : "Show More" }}
        </span>
        <Icon
          icon="fluent:chevron-down-16-regular"
          :class="showListingDropDown ? 'rotate-180' : ''"
          class="mt-[2px] h-[14px] w-[14px] transition-all duration-150"
        />
      </button>
    </section>
  </KeepAlive>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { useListingDetailStore } from "@/State/ListingDetailStore";
import { computed, ref } from "vue";

const props = defineProps({
  job_listing: Object,
  listing_language: String,
});

const listingStore = useListingDetailStore();

// const showListingDropDown = computed(() => listingStore.state.showMore);
const showListingDropDown = ref(false);

const handleListingDropDown = () => {
  showListingDropDown.value = !showListingDropDown.value;
  listingStore.actions.setShowMore(!listingStore.state.showMore);
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
