<template>
  <ContentBox>
    <section class="p-4 md:p-6 flex flex-col gap-4">
      <div>
        <div class="flex items-start justify-between">
          <h4>{{ certification.title }}</h4>
          <ActionMenu class="-mr-3" @delete="handleDelete" :inline-edit="false" @edit="showModal = true" />
        </div>

        <p class="helper-text-sm">
          <span>{{ certification.organisation }}</span>
          <span>, Certification Date: {{ certification.certification_date }}</span>
          <span>, Expiration Date: {{ certification.expiration_date }}</span>
        </p>
      </div>
      <div class="whitespace-pre-wrap" v-html="certification.additional_information"></div>
    </section>
    <CertificationForm
      :show-modal="showModal"
      @close="showModal = false"
      modal-title="Edit Certification"
      :certification="certification"
      success-button="Save Changes"
    />
  </ContentBox>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import ActionMenu from "../UI/ActionMenu.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import CertificationForm from "./CertificationForm.vue";

const props = defineProps({
  certification: Object,
});

const showModal = ref(false);

const handleDelete = () => {
  router.delete(route("certification.destroy", props.certification.id));
};
</script>
