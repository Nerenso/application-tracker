<template>
  <ContentBox>
    <section class="p-4 md:p-6 flex flex-col gap-4">
      <div class="">
        <div class="flex items-start justify-between">
          <h4>{{ education.degree_name }}</h4>
          <ActionMenu class="-mr-3" @delete="handleDelete" :inline-edit="false" @edit="showModal = true" />
        </div>

        <p class="helper-text-sm">
          <span class="">{{ education.institution_name }}</span>
          <span v-if="education.location" class="">, {{ education.location }}</span>
          <span class="">, {{ education.years_attended }}</span>
        </p>
        <p class="helper-text-sm mt-1">{{ education.academic_progress }}</p>
      </div>
      <div class="whitespace-pre-wrap" v-html="education.additional_information"></div>
    </section>
    <EducationForm
      :show-modal="showModal"
      @modal-closed="showModal = false"
      modal-title="Edit Education"
      :education="education"
      success-button-text="Save Changes"
    />
  </ContentBox>
</template>

<script setup>
import { ref } from "vue";
import ActionMenu from "../UI/ActionMenu.vue";
import ContentBox from "../UI/ContentBox.vue";
import EducationForm from "./EducationForm.vue";
import { router } from "@inertiajs/vue3";

const showModal = ref(false);

const props = defineProps({
  education: Object,
});

const handleDelete = () => {
  router.delete(route("education.destroy", props.education.id));
};
</script>
