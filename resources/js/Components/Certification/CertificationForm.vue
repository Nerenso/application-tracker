<template>
  <BaseModal
    :show-modal="showModal"
    @close="handleClose"
    :title="modalTitle"
    :success-button="successButton"
    @save="submit"
    @beforeEnter="handleBeforeEnter"
    @afterLeave="handleAfterLeave"
    :loading="loading"
  >
    <template #content>
      <form class="w-full space-y-6" @submit.prevent="submit">
        <div class="w-full">
          <BaseLabel :is-required="true" label="Name of Certification">
            <XInput
              class="w-full"
              v-model="certificationForm.title"
              placeholder="Google Ads Search Certification
"
            />
            <p class="form-error">{{ certificationForm.errors.title }}</p>
          </BaseLabel>
        </div>

        <div class="w-full">
          <BaseLabel :is-required="true" label="Issuing Organisation">
            <XInput class="w-full" v-model="certificationForm.organisation" placeholder="Google LLC" />
            <p class="form-error">{{ certificationForm.errors.organisation }}</p>
          </BaseLabel>
        </div>

        <div class="w-full">
          <BaseLabel label="Date of Certification">
            <XInput class="w-full" v-model="certificationForm.certification_date" placeholder="06/2021" />
            <p class="form-error">{{ certificationForm.errors.certification_date }}</p>
          </BaseLabel>
        </div>

        <div class="w-full">
          <BaseLabel label="Expiration Date">
            <XInput class="w-full" v-model="certificationForm.expiration_date" placeholder="06/2023" />
            <p class="form-error">{{ certificationForm.errors.expiration_date }}</p>
          </BaseLabel>
        </div>

        <div>
          <BaseLabel label="Additional Details">
            <XTextarea
              :adjust-to-text="false"
              class="w-full"
              rows="5"
              placeholder="Relevant topics: data analytics, business strategy, digital marketing (content display, email, local, social media, video, SEM, SEO), and web optimisation"
              v-model="certificationForm.additional_information"
            />
            <p class="form-error">{{ certificationForm.errors.additional_information }}</p>
          </BaseLabel>
        </div>
      </form>
    </template>
  </BaseModal>
</template>

<script setup>
import BaseModal from "@/Components/UI/BaseModal.vue";
import { useForm } from "@inertiajs/vue3";
import BaseLabel from "../UI/BaseLabel.vue";
import { XInput, XTextarea } from "@indielayer/ui";
import { ref } from "vue";

const props = defineProps({
  certification: Object,
  showModal: Boolean,
  modalType: String,
  modalTitle: String,
  successButton: String,
});

const loading = ref(false);
const emit = defineEmits(["close"]);

const certificationForm = useForm({
  title: "",
  organisation: "",
  certification_date: "",
  expiration_date: "",
  additional_information: "",
});

const handleClose = () => {
  emit("close");
};

const resetForm = () => {
  certificationForm.title = "";
  certificationForm.organisation = "";
  certificationForm.certification_date = "";
  certificationForm.expiration_date = "";
  certificationForm.description = "";
};

const formOptions = {
  onStart: () => {
    loading.value = true;
  },
  onSuccess: () => {
    handleClose();
  },
  onError: () => {
    loading.value = false;
  },
};

const submit = () => {
  if (props.modalType == "New") {
    certificationForm.post(route("certification.store"), formOptions);
  } else {
    certificationForm.patch(route("certification.update", props.certification.id), formOptions);
  }
};

const handleBeforeEnter = () => {
  if (props.certification) {
    certificationForm.title = props.certification.title;
    certificationForm.organisation = props.certification.organisation;
    certificationForm.certification_date = props.certification.certification_date;
    certificationForm.expiration_date = props.certification.expiration_date;
    certificationForm.additional_information = props.certification.additional_information;
  }
};

const handleAfterLeave = () => {
  certificationForm.clearErrors();
  loading.value = false;
  resetForm();
};
</script>
