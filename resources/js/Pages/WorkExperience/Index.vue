<template>
  <DashboardLayout title="Work Experience">
    <Head title="Work Experience" />
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block"
        >Add Experience</XButton
      >
      <div
        @click="openModal"
        class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-500 text-white md:hidden"
      >
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <div class="min-h-screen w-full">
      <section v-if="workExperiences.length <= 0" class="w-full p-2">
        <EmptyState>
          <div class="mb-4 flex flex-col gap-4">
            <p class="empty-state-text">
              You haven't added any work experiences yet. Try adding some.
            </p>
            <XButton class="mx-auto w-fit" color="primary" @click="openModal"
              >Add New Work Experience</XButton
            >
          </div>
        </EmptyState>
      </section>
      <section v-else class="w-full p-2 md:p-6">
        <div class="mx-auto w-full max-w-5xl">
          <div class="my-4 grid grid-cols-1 gap-4">
            <WorkExperience
              v-for="experience in workExperiences"
              :key="experience.id"
              :work-experience="experience"
            />
          </div>
        </div>
      </section>
    </div>
    <BaseModal
      button-text="Add Experience"
      title="Add New Work Experience"
      :show-modal="showModal"
      @close="showModal = false"
      @save="submit"
    >
      <template #content>
        <form class="w-full space-y-6" @submit.prevent="submit">
          <div class="w-full">
            <BaseLabel :is-required="true" label="Job Title">
              <XInput
                class="w-full"
                v-model="workExperienceForm.job_title"
                placeholder="Sales Manager"
              />
              <p class="form-error">
                {{ workExperienceForm.errors.job_title }}
              </p>
            </BaseLabel>
          </div>
          <div class="w-full">
            <BaseLabel :is-required="false" label="Employment Period">
              <XInput
                class="w-full"
                v-model="workExperienceForm.employment_period"
                placeholder="05/2017 - 09/2022"
              />
              <p class="form-error">
                {{ workExperienceForm.errors.employment_period }}
              </p>
            </BaseLabel>
          </div>
          <div>
            <BaseLabel label="Job Description" is-required>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Describe the responsibilities you had in this position, make
                sure to use active langauge.
              </p>

              <XTextarea
                :adjust-to-text="false"
                class="mt-2 w-full"
                rows="3"
                placeholder="Add your notes about this listing here..."
                v-model="workExperienceForm.job_description"
              />
              <p class="form-error">
                {{ workExperienceForm.errors.job_description }}
              </p>
            </BaseLabel>
          </div>
          <div class="w-full">
            <BaseLabel label="Company Name">
              <XInput
                class="w-full"
                v-model="workExperienceForm.company_name"
                placeholder="Lenovo"
              />
              <p class="form-error">
                {{ workExperienceForm.errors.company_name }}
              </p>
            </BaseLabel>
          </div>
        </form>
      </template>
      <template #action>
        <!-- <XButton @click="submit" color="primary" :loading="loading">Add Experience</XButton> -->
      </template>
    </BaseModal>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import WorkExperience from "@/Components/WorkExperience/WorkExperience.vue";
import { XButton, XInput, XTextarea } from "@indielayer/ui";
import { Icon } from "@iconify/vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import BaseModal from "@/Components/UI/BaseModal.vue";
import { ref } from "vue";
import { useForm, Head } from "@inertiajs/vue3";
import BaseLabel from "@/Components/UI/BaseLabel.vue";

const props = defineProps({
  workExperiences: Object,
});

const showModal = ref(false);
const loading = ref(false);

const workExperienceForm = useForm({
  job_title: "",
  employment_period: "",
  company_name: "",
  job_description: "",
});

const resetForm = () => {
  workExperienceForm.job_title = "";
  workExperienceForm.employment_period = "";
  workExperienceForm.company_name = "";
  workExperienceForm.job_description = "";

  showModal.value = false;
};

const openModal = () => {
  showModal.value = true;
};

const setLoading = () => {
  loading.value = !loading.value;
};

const submit = () => {
  workExperienceForm.clearErrors();
  workExperienceForm.post(route("work-experience.store"), {
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
