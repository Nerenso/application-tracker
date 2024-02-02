<template>
  <Head title="Profile" />

  <DashboardLayout title="Account">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Profile</h2>
    </template> -->

    <div class="py-12 px-2 md:px-6">
      <div class="max-w-5xl mx-auto lg:px-0 space-y-6">
        <ContentBox class="p-4 sm:p-8">
          <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
        </ContentBox>

        <ContentBox class="p-4 sm:p-8">
          <UpdatePasswordForm class="max-w-xl" />
        </ContentBox>

        <ContentBox class="p-4 sm:p-8">
          <DeleteUserForm class="max-w-xl" />
        </ContentBox>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup>
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ContentBox from "@/Components/UI/ContentBox.vue";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
</script>
