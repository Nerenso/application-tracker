<template>
  <ContentBox>
    <section class="p-4 md:p-6 flex flex-col gap-4">
      <div class="space-y-1">
        <div class="flex items-start justify-between">
          <h4>{{ workExperience.job_title }}</h4>
          <ActionMenu class="-mr-3" @delete="handleDelete" :inline-edit="false" @edit="openModal" />
        </div>
        <div>
          <h5>{{ workExperience.company_name }}</h5>
          <p class="helper-text-sm">{{ workExperience.employment_period }}</p>
        </div>
      </div>
      <div class="whitespace-pre-wrap" v-html="workExperience.job_description"></div>
    </section>
  </ContentBox>
  <BaseModal
    title="Edit Work Experience"
    :show-modal="showModal"
    @close="showModal = false"
    @save="submit"
    :loading="loading"
    success-button="Save Changes"
  >
    <template #content>
      <form class="w-full space-y-6" @submit.prevent="submit">
        <div class="w-full">
          <BaseLabel :is-required="true" label="Job Title">
            <XInput class="w-full" v-model="workExperienceForm.job_title" placeholder="Sales Manager" />
            <p class="form-error">{{ workExperienceForm.errors.job_title }}</p>
          </BaseLabel>
        </div>
        <div class="w-full">
          <BaseLabel :is-required="false" label="Employment Period">
            <XInput class="w-full" v-model="workExperienceForm.employment_period" placeholder="05/2017 - 09/2022" />
            <p class="form-error">{{ workExperienceForm.errors.employment_period }}</p>
          </BaseLabel>
        </div>
        <div>
          <BaseLabel label="Job Description" is-required>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Describe the responsibilities you had in this position, make sure to use active langauge.
            </p>
            <XTextarea
              :adjust-to-text="false"
              class="w-full mt-2"
              rows="3"
              placeholder="Add your notes about this listing here..."
              v-model="workExperienceForm.job_description"
            />
            <p class="form-error">{{ workExperienceForm.errors.job_description }}</p>
          </BaseLabel>
        </div>
        <div class="w-full">
          <BaseLabel label="Company Name">
            <XInput class="w-full" v-model="workExperienceForm.company_name" placeholder="Lenovo" />
            <p class="form-error">{{ workExperienceForm.errors.company_name }}</p>
          </BaseLabel>
        </div>
      </form>
    </template>
    <template #action>
      <XButton @click="submit" color="primary" :loading="loading">Save Changes</XButton>
    </template>
  </BaseModal>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import BaseModal from "../UI/BaseModal.vue";
import BaseLabel from "../UI/BaseLabel.vue";
import ActionMenu from "@/Components/UI/ActionMenu.vue";
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { XButton } from "@indielayer/ui";

const props = defineProps({
  workExperience: Object,
});

const showModal = ref(false);
const loading = ref(false);

const setLoading = () => {
  loading.value = !loading.value;
};

const workExperienceForm = useForm({
  job_title: props.workExperience.job_title,
  employment_period: props.workExperience.employment_period,
  company_name: props.workExperience.company_name,
  job_description: props.workExperience.job_description,
});

const openModal = () => {
  workExperienceForm.job_title = props.workExperience.job_title;
  workExperienceForm.employment_period = props.workExperience.employment_period;
  workExperienceForm.company_name = props.workExperience.company_name;
  workExperienceForm.job_description = props.workExperience.job_description;

  showModal.value = true;
};

const resetForm = () => {
  showModal.value = false;
};

const submit = () => {
  workExperienceForm.clearErrors();
  workExperienceForm.patch(route("work-experience.update", props.workExperience.id), {
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

const handleDelete = () => {
  console.log(`${props.workExperience.job_title} deleted`);
  router.delete(route("work-experience.destroy", props.workExperience.id));
};
</script>
