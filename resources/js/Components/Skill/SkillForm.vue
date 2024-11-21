<template>
  <BaseModal
    :show-modal="showModal"
    @close="handleClose"
    :title="modalTitle"
    :button-text="successButton"
    @save="submit"
    @beforeEnter="handleBeforeEnter"
    @afterLeave="handleAfterLeave"
    :loading="loading"
  >
    <template #content>
      <form class="w-full space-y-6" @submit.prevent="submit">
        <div class="w-full">
          <BaseLabel :is-required="true" label="Skill Title">
            <XInput
              class="w-full"
              v-model="skillForm.title"
              placeholder="Programming"
            />
            <p class="form-error">{{ skillForm.errors.title }}</p>
          </BaseLabel>
        </div>
        <div>
          <BaseLabel label="Description" is-required>
            <XTextarea
              :adjust-to-text="false"
              class="w-full"
              rows="5"
              placeholder="Programming languages: C#, Python, Javascript, HTML, CSS and PHP. Frameworks: VueJS, React, Laravel, Django, Nuxt, NextJS, Express, AlpineJS, GSAP, Tailwind."
              v-model="skillForm.description"
            />
            <p class="form-error">{{ skillForm.errors.description }}</p>
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
  skill: Object,
  showModal: Boolean,
  modalType: String,
  modalTitle: String,
  successButton: String,
});

const loading = ref(false);
const emit = defineEmits(["close"]);

const skillForm = useForm({
  title: "",
  description: "",
});

const handleClose = () => {
  emit("close");
};

const resetForm = () => {
  skillForm.title = "";
  skillForm.description = "";
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
    skillForm.post(route("skill.store"), formOptions);
  } else {
    skillForm.patch(route("skill.update", props.skill.id), formOptions);
  }
};

const handleBeforeEnter = () => {
  if (props.skill) {
    skillForm.title = props.skill.title;
    skillForm.description = props.skill.description;
  }
};

const handleAfterLeave = () => {
  skillForm.clearErrors();
  loading.value = false;
  resetForm();
};
</script>
