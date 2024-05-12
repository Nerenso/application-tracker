<template>
  <div>
    <BaseModal :success-button="successButtonText" :title="modalTitle" :show-modal="showModal" @close="handleClose" @save="submit">
      <template #content>
        <form class="w-full space-y-6" @submit.prevent="submit">
          <div class="w-full">
            <BaseLabel :is-required="true" label="Degree Name">
              <XInput class="w-full" v-model="educationForm.degree_name" placeholder="Bachelor of Arts (B.A.), English Literature" />
              <p class="form-error">{{ educationForm.errors.degree_name }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel :is-required="true" label="Institution Name">
              <XInput class="w-full" v-model="educationForm.institution_name" placeholder="University of Amsterdam" />
              <p class="form-error">{{ educationForm.errors.degree_name }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel label="Institution Location">
              <XInput class="w-full" v-model="educationForm.location" placeholder="Amsterdam" />
              <p class="form-error">{{ educationForm.errors.location }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel :is-required="true" label="Years Attended">
              <XInput class="w-full" v-model="educationForm.years_attended" placeholder="09/2014 - 06/2018" />
              <p class="form-error">{{ educationForm.errors.years_attended }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel label="Academic Progress">
              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Write about the state of your study, if you completed it or when you expect to graduate. Additionally you could include your GPA
                score, or how many completed credits you got.
              </p>
              <XInput
                class="w-full"
                v-model="educationForm.academic_progress"
                placeholder="Expected Graduation: 06/2026 | Completed 25 credits towards Bachelor Degree "
              />
              <p class="form-error">{{ educationForm.errors.academic_progress }}</p>
            </BaseLabel>
          </div>

          <div>
            <BaseLabel label="Additional Information">
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Write any extra information about your education, such as relevant coursework, honors and awards, thesis or dissertation.
              </p>

              <XTextarea
                :adjust-to-text="false"
                class="w-full mt-4"
                rows="3"
                placeholder="Additional information about education..."
                v-model="educationForm.additional_information"
              />
              <p class="form-error">{{ educationForm.errors.additional_information }}</p>
            </BaseLabel>
          </div>
        </form>
      </template>
    </BaseModal>
  </div>
</template>

<script setup>
import { XInput, XTextarea } from "@indielayer/ui";
import BaseLabel from "../UI/BaseLabel.vue";
import BaseModal from "../UI/BaseModal.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onUpdated } from "vue";

const props = defineProps({
  education: Object,
  showModal: Boolean,
  successButtonText: String,
  modalTitle: String,
  modalType: String,
});

const loading = ref(true);
const emit = defineEmits(["modalClosed"]);

const formOptions = {
  onStart: () => {
    setLoading();
  },
  onSuccess: () => {
    handleClose();
  },
  onError: () => {
    setLoading();
  },
};

const educationForm = useForm({
  degree_name: "",
  institution_name: "",
  location: "",
  years_attended: "",
  academic_progress: "",
  additional_information: "",
});

const resetForm = () => {
  educationForm.degree_name = "";
  educationForm.institution_name = "";
  educationForm.location = "";
  educationForm.years_attended = "";
  educationForm.academic_progress = "";
  educationForm.additional_information = "";
};

function handleClose() {
  emit("modalClosed");
  educationForm.clearErrors();
  setLoading();
  resetForm();
}

const setLoading = () => {
  loading.value = !loading.value;
};

const submit = () => {
  if (props.modalType == "New") {
    educationForm.post(route("education.store"), formOptions);
  } else {
    educationForm.patch(route("education.update", props.education.id), formOptions);
  }
};

onUpdated(() => {
  if (props.education) {
    educationForm.degree_name = props.education.degree_name;
    educationForm.institution_name = props.education.institution_name;
    educationForm.location = props.education.location;
    educationForm.years_attended = props.education.years_attended;
    educationForm.academic_progress = props.education.academic_progress;
    educationForm.additional_information = props.education.additional_information;
  }
});
</script>
