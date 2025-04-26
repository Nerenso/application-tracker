<template>
  <BaseModal
    :show-modal="showModal"
    title="Change Listing Status"
    button-text="Update Status"
    @close="closeModal"
    @save="submitForm"
  >
    <template #content>
      <form @submit.prevent="" class="min-h-80">
        <p>
          You are about to update the status for the
          <span class="font-semibold">{{ listing.page_title }}</span> position
          at <span class="font-semibold">{{ listing.company_name }}</span
          >.
        </p>

        <div class="relative mt-4 w-full sm:flex sm:gap-4">
          <div class="w-full">
            <BaseLabel class="w-full" label="New Status" :is-required="true">
              <XSelect
                class="w-full"
                v-model="statusUpdateForm.selectedStatus"
                :options="statusOptions"
              ></XSelect>
              <p class="form-error">
                {{ statusUpdateForm.errors.selectedStatus }}
              </p>
            </BaseLabel>
          </div>
          <div
            v-if="statusUpdateForm.selectedStatus !== 'added'"
            class="mt-4 w-full sm:mt-0"
          >
            <BaseLabel class="w-full" label="Date" :is-required="true">
              <XInput
                class="w-full"
                type="date"
                v-model="statusUpdateForm.selectedDate"
              />
              <p class="form-error">
                {{ statusUpdateForm.errors.selectedDate }}
              </p>
            </BaseLabel>
          </div>
        </div>
      </form>
    </template>
  </BaseModal>
</template>

<script setup>
import BaseModal from "@/Components/UI/BaseModal.vue";
import { XInput, XSelect } from "@indielayer/ui";
import { ref } from "vue";
import BaseLabel from "../UI/BaseLabel.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
  showModal: {
    type: Boolean,
    required: true,
  },
});

const statusUpdateForm = useForm({
  selectedStatus: props.listing.status,
  selectedDate: new Date().toISOString().split("T")[0],
});

const submitForm = () => {
  if (statusUpdateForm.selectedStatus === "added") {
    statusUpdateForm.selectedDate = new Date(
      props.listing.created_at,
    ).toISOString();
  }

  statusUpdateForm.patch(route("job-listing.updateStatus", props.listing.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
    },
    onError: () => {
      console.log("Error updating status");
    },
  });
};

watch(
  () => statusUpdateForm.selectedStatus,
  (newVal) => {
    console.log(newVal);
    if (newVal !== "added") {
      statusUpdateForm.selectedDate = new Date().toISOString().split("T")[0];
    }
  },
);

const statusOptions = [
  { value: "added", label: "Added" },
  { value: "applied", label: "Applied" },
  { value: "interviewing", label: "Interviewing" },
  { value: "offer", label: "Offer Received" },
  { value: "rejected", label: "Rejected" },
];

const emit = defineEmits(["close"]);

const closeModal = () => {
  setTimeout(() => {
    statusUpdateForm.reset();
    statusUpdateForm.clearErrors();
  }, 200);
  emit("close");
};
</script>
