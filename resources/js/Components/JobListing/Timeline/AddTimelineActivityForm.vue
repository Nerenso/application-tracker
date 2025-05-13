<template>
  <BaseModal
    title="Add Timeline Activity"
    button-text="Add Activity"
    :show-modal="showModal"
    @close="resetTimelineActivityForm"
    @save="submitTimelineActivityForm"
  >
    <template #content>
      <form @submit.prevent>
        <p class="">
          Add an activity the for the
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
import RadioSelect from "@/Components/UI/RadioSelect.vue";
import { useUIStore } from "@/State/UIStore";
import { XInput, XTextarea } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  showModal: Boolean,
  listing: Object,
});

const loading = ref(false);
const uiStore = useUIStore();

const timelineActivityForm = useForm({
  title: "",
  activity_date: new Date().toISOString().split("T")[0],
  description: "",
});

const emit = defineEmits(["update:showModal"]);

const resetTimelineActivityForm = () => {
  uiStore.actions.setShowAddActivityForm(false);
  setLoading(false);
  setTimeout(() => {
    timelineActivityForm.clearErrors();
    timelineActivityForm.title = "";
    timelineActivityForm.description = "";
    timelineActivityForm.activity_date = new Date().toISOString().split("T")[0];
  }, 200);
};

const setShowModal = (newVal) => {
  emit("update:showModal", newVal);
  if (!newVal) {
    resetTimelineActivityForm();
    uiStore.actions.setShowAddActivityForm(newVal);
  }
};

const setLoading = (newValue) => {
  loading.value = newValue;
};

const submitTimelineActivityForm = () => {
  timelineActivityForm.post(route("activity.store", props.listing.id), {
    preserveScroll: true,
    onStart: () => {
      setLoading(true);
    },
    onSuccess: () => {
      resetTimelineActivityForm();
    },
  });
};
</script>
