<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ContentBox class="mx-auto w-full max-w-5xl p-4 sm:p-6">
      <header class="flex items-center justify-between">
        <h4>Activity Timeline</h4>
        <button
          @click="setShowAddActivityForm(true)"
          class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-500 text-white transition-all duration-150 hover:bg-teal-600"
        >
          <Icon icon="mi:add" class="" />
        </button>
      </header>

      <TimelineWrapper as="ol">
        <li v-for="activity in timelineActivities" :key="activity.id">
          <TimelineItem
            v-if="activity.activity_type == 'listing_created'"
            :date="listing.created_at"
          >
            <template #title>
              <p class="">
                Listing added for the
                <span class="font-medium">{{ listing.page_title }}</span>
                role at
                <span class="font-medium">{{ listing.company_name }}</span
                >.
              </p>
            </template>

            <template #content>
              <div v-if="activity.description" class="mt-2 flex flex-col gap-2">
                <p
                  v-for="(paragraph, index) in activity.description.split(
                    '\n\n',
                  )"
                  :key="index"
                  class="text-sm text-slate-600 dark:text-gray-200"
                >
                  {{ paragraph }}
                </p>
              </div>
            </template>
          </TimelineItem>

          <TimelineItem
            v-if="activity.activity_type == 'status_updated'"
            :date="activity.activity_date"
          >
            <template #title>
              <p class="w-full">
                Status changed to
                <span class="font-medium">
                  {{ statusData[activity.description].label }} </span
                >.
              </p>
            </template>
          </TimelineItem>

          <TimelineItem
            v-if="activity.activity_type == 'note_added'"
            :date="activity.activity_date"
            :editable="true"
            @edit="setShowEditActivityForm(true, activity)"
            @delete="deleteActivity(activity)"
          >
            <template #title>
              <p class="font-medium">
                {{ activity.title }}
              </p>
            </template>
            <template #content>
              <div
                v-if="activity.description"
                class="mt-2 flex flex-col gap-2 pr-4 sm:pr-8"
              >
                <p
                  v-for="(paragraph, index) in activity.description.split(
                    '\n\n',
                  )"
                  :key="index"
                  class="text-sm text-slate-600 dark:text-gray-200"
                >
                  {{ paragraph }}
                </p>
              </div>
              <EditTimelineActivityForm
                v-if="isSelectedActivity(activity)"
                :activity="selectedActivity"
                v-model:show-modal="showEditAcitivtyForm"
                :listing="listing"
              />
            </template>
          </TimelineItem>
        </li>
      </TimelineWrapper>
    </ContentBox>
  </ListingDetailLayout>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";
import AddTimelineActivityForm from "@/Components/JobListing/Timeline/AddTimelineActivityForm.vue";
import { Icon } from "@iconify/vue";
import { statusData } from "@/Utils/ListingStatusProperties";
import TimelineWrapper from "@/Components/UI/TimelineWrapper.vue";
import TimelineItem from "@/Components/UI/TimelineItem.vue";
import { useUIStore } from "@/State/UIStore";
import EditTimelineActivityForm from "@/Components/JobListing/Timeline/EditTimelineActivityForm.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  listing: Object,
  tags: Array,
  timelineActivities: Array,
});

const uiStore = useUIStore();
const selectedActivity = ref(null);
const showEditAcitivtyForm = ref(false);

const setSelectedActivity = (activity) => {
  selectedActivity.value = activity;
};

const setShowAddActivityForm = (newVal) => {
  uiStore.actions.setShowAddActivityForm(newVal);
};

const setShowEditActivityForm = (newVal, activity) => {
  if (newVal) {
    showEditAcitivtyForm.value = true;
    setSelectedActivity(activity);
  } else {
    showEditAcitivtyForm.value = false;
    setSelectedActivity(null);
  }
};

const isSelectedActivity = (activity) => {
  return selectedActivity.value?.id == activity?.id;
};

const deleteActivity = (activity) => {
  router.delete(
    route("activity.destroy", {
      job_listing: props.listing.id,
      activity: activity.id,
    }),
    {
      preserveScroll: true,
    },
  );
};
</script>
