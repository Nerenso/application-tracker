<template>
  <KeepAlive>
    <section class="relative">
      <div class="flex items-center justify-between">
        <h3>{{ listing_language == "nl" ? "Functieomschrijving" : "Job Description" }}</h3>
      </div>
      <p>{{ job_listing.job_description }}</p>

      <article :class="showListingDropDown ? 'extended' : 'shrunk'">
        <div class="overflow-y-hidden mb-4">
          <div>
            <h3>{{ listing_language == "nl" ? "Bedrijfsinformatie" : "Company Information" }}</h3>
            <p>{{ job_listing.company_information }}</p>
          </div>

          <div>
            <h3>{{ listing_language == "nl" ? "Vereisten" : "Requirements" }}</h3>
            <ul class="list-disc ml-5 sm:ml-4 space-y-1">
              <li v-for="(requirement, i) in job_listing.requirements" :key="i">{{ requirement }}</li>
            </ul>
          </div>

          <div>
            <h3>{{ listing_language == "nl" ? "Wat Ze Bieden" : "What They Offer" }}</h3>
            <ul class="list-disc ml-5 sm:ml-4 space-y-1">
              <li v-for="(offer, i) in job_listing.what_they_offer" :key="i">{{ offer }}</li>
            </ul>
          </div>

          <div>
            <h3>{{ listing_language == "nl" ? "Overige Informatie" : "Additional Information" }}</h3>
            <ul class="list-disc ml-5 sm:ml-4 space-y-1">
              <li v-for="(detail, i) in job_listing.important_details" :key="i">{{ detail }}</li>
            </ul>
          </div>
        </div>
      </article>
      <button class="bg-white border rounded-md px-3 py-2 flex justify-between items-center gap-1" size="sm" @click="handleListingDropDown">
        <span class="font-medium text-sm">
          {{ showListingDropDown ? "Show Less" : "Show More" }}
        </span>
        <Icon
          icon="fluent:chevron-down-16-regular"
          :class="showListingDropDown ? 'rotate-180' : ''"
          class="transition-all duration-150 h-[14px] w-[14px] mt-[2px]"
        />
      </button>
    </section>
  </KeepAlive>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { useListingDetailStore } from "@/State/ListingDetailStore";
import { computed } from "vue";

const props = defineProps({
  job_listing: Object,
  listing_language: String,
});

const listingStore = useListingDetailStore();

const showListingDropDown = computed(() => listingStore.state.showMore);

const handleListingDropDown = () => {
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
