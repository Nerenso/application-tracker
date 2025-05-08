<template>
  <BaseModal
    @close="closeModal"
    :show-modal="showModal"
    title="Edit Job Listing"
    button-text="Save Changes"
    @save="submit"
  >
    <template #content>
      <form class="w-full">
        <p>
          You are about to edit the details for the
          <span class="font-semibold">{{ listingInfo.page_title }}</span>
          position at
          <span class="font-semibold">{{ listingInfo.company_name }}</span
          >.
        </p>

        <div class="mt-6 flex w-full items-center gap-2">
          <section class="w-full">
            <XInput
              type="number"
              label="Min. Salary"
              placeholder="2.000"
              class="w-full"
              v-model="listingForm.salary_from"
            />
            <p class="form-error">{{ listingForm.errors.salary_from }}</p>
          </section>

          <section class="w-full">
            <XInput
              type="number"
              label="Max. Salary"
              placeholder="3.500"
              v-model="listingForm.salary_to"
              class="w-full"
            />
            <p class="form-error">{{ listingForm.errors.salary_to }}</p>
          </section>
        </div>

        <section class="mt-4">
          <XInput
            label="Location"
            placeholder="Amsterdam"
            class="w-full"
            v-model="listingForm.location"
          />
          <p class="form-error">{{ listingForm.errors.location }}</p>
        </section>

        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-2">
          <section class="w-full">
            <XInput
              type="text"
              label="Contact Phone"
              placeholder="06-12345678"
              class="w-full"
              v-model="listingForm.contact_phone"
            />
            <p class="form-error">{{ listingForm.errors.contact_phone }}</p>
          </section>

          <section class="w-full">
            <XInput
              label="Contact Name"
              placeholder="John"
              class="w-full"
              v-model="listingForm.contact_name"
            />
            <p class="form-error">{{ listingForm.errors.contact_name }}</p>
          </section>
        </div>

        <section class="mt-6">
          <XInput
            type="email"
            label="Contact Email"
            placeholder="john@google.com"
            v-model="listingForm.contact_email"
            class="w-full"
          />
          <p class="form-error">{{ listingForm.errors.contact_email }}</p>
        </section>
      </form>
    </template>
  </BaseModal>
</template>

<script setup>
import BaseModal from "@/Components/UI/BaseModal.vue";

import { Icon } from "@iconify/vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { onMounted, ref } from "vue";
import BaseLabel from "../UI/BaseLabel.vue";
import { XInput, XTextarea } from "@indielayer/ui";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
  tags: Array,
  showModal: Boolean,
});

const emit = defineEmits(["close"]);

const listingForm = useForm({
  job_link: "",
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
  location: "",
});

const closeModal = () => {
  emit("close");
};

onMounted(() => {
  listingForm.job_link = props.listingInfo?.listing_url;
  listingForm.notes = props.listingInfo?.notes;
  listingForm.salary_from = props.listingInfo?.salary_from;
  listingForm.salary_to = props.listingInfo?.salary_to;
  listingForm.contact_name = props.listingInfo?.contact_name;
  listingForm.contact_phone = props.listingInfo?.contact_phone;
  listingForm.contact_email = props.listingInfo?.contact_email;
  listingForm.location = props.listingInfo?.location;
});

const imageError = ref(false);

const setLoading = () => {
  loading.value = !loading.value;
};

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.selectedMultiple = [];
  listingForm.notes = "";
  listingForm.salary_from = null;
  listingForm.salary_to = null;
  listingForm.contact_name = "";
  listingForm.contact_phone = "";
  listingForm.contact_email = "";
  listingForm.location = "";
  showModal.value = false;
};

const submit = () => {
  listingForm.clearErrors();
  listingForm.post(route("job-listing.store"), {
    onStart: () => {
      setLoading();
    },
    onSuccess: () => {
      resetForm();
      setLoading();
    },
    onError: () => {
      setLoading();
    },
  });
};
</script>
