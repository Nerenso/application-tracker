<template>
  <BaseModal
    title="Edit Timeline Activity"
    button-text="Save Changes"
    :show-modal="showModal"
    @close="resetTimelineActivityForm"
    @save="submitTimelineActivityForm"
  >
    <template #content>
      <form @submit.prevent>
        <p class="">
          Edit an activity the for the
          <span class="font-semibold">{{ listing.page_title }}</span>
          position at
          <span class="font-semibold">{{ listing.company_name }}</span
          >.
        </p>
        <div class="mt-6 flex flex-col space-y-6">
          <BaseLabel label="Activity Title" is-required class="w-full">
            <XInput
              placeholder="Enter Activity Title"
              class="w-full"
              v-model="timelineActivityForm.title"
            />
            <p v-if="timelineActivityForm.errors.title" class="form-error">
              {{ timelineActivityForm.errors.title }}
            </p>
          </BaseLabel>

          <BaseLabel label="Activity Date" is-required class="w-full">
            <XInput
              placeholder="Enter Activity Date"
              type="date"
              class="w-full"
              v-model="timelineActivityForm.activity_date"
            />
            <p
              v-if="timelineActivityForm.errors.activity_date"
              class="form-error"
            >
              {{ timelineActivityForm.errors.activity_date }}
            </p>
          </BaseLabel>

          <BaseLabel label="Activity Description" is-required class="w-full">
            <XTextarea
              class="w-full"
              placeholder="Enter Activity Description"
              v-model="timelineActivityForm.description"
              rows="10"
              :block="true"
              :adjust-to-text="false"
            />
            <p
              v-if="timelineActivityForm.errors.description"
              class="form-error"
            >
              {{ timelineActivityForm.errors.description }}
            </p>
          </BaseLabel>
        </div>
      </form>
    </template>
  </BaseModal>
</template>

<script setup>
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import BaseModal from "@/Components/UI/BaseModal.vue";
import { useUIStore } from "@/State/UIStore";
import { XInput, XTextarea } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  showModal: Boolean,
  activity: Object,
  listing: Object,
});

const loading = ref(false);
const uiStore = useUIStore();

const timelineActivityForm = useForm({
  title: props.activity.title,
  activity_date: new Date(props.activity.activity_date)
    .toISOString()
    .split("T")[0],
  description: props.activity.description,
});

const emit = defineEmits(["close", "update:showModal"]);

const resetTimelineActivityForm = () => {
  emit("update:showModal", false);
  setLoading(false);
  setTimeout(() => {
    timelineActivityForm.clearErrors();
    timelineActivityForm.title = props.activity.title;
    timelineActivityForm.activity_date = new Date().toISOString().split("T")[0];
    timelineActivityForm.description = props.activity.description;
  }, 200);
};

const setShowModal = (newVal) => {
  emit("close");
  if (!newVal) {
    resetTimelineActivityForm();
    uiStore.actions.setShowAddActivityForm(newVal);
  }
};

const setLoading = (newValue) => {
  loading.value = newValue;
};

const submitTimelineActivityForm = () => {
  timelineActivityForm.patch(
    route("activity.update", {
      job_listing: props.listing.id,
      activity: props.activity.id,
    }),
    {
      preserveScroll: true,
      onStart: () => {
        setLoading(true);
      },
      onSuccess: () => {
        resetTimelineActivityForm();
      },
    },
  );
};
</script>
