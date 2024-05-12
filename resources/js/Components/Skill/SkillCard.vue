<template>
  <ContentBox>
    <section class="p-4 md:p-6 flex flex-col gap-1">
      <div class="">
        <div class="flex items-start justify-between">
          <h4>{{ skill.title }}</h4>
          <ActionMenu class="-mr-3" @delete="handleDelete" :inline-edit="false" @edit="showModal = true" />
        </div>
      </div>
      <div class="whitespace-pre-wrap" v-html="skill.description"></div>
    </section>
    <SkillForm :show-modal="showModal" @close="showModal = false" modal-title="Edit Skill" :skill="skill" success-button="Save Changes" />
  </ContentBox>
</template>

<script setup>
import ContentBox from "@/Components/UI/ContentBox.vue";
import ActionMenu from "../UI/ActionMenu.vue";
import SkillForm from "./SkillForm.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  skill: Object,
});

const showModal = ref(false);

const handleDelete = () => {
  router.delete(route("skill.destroy", props.skill.id));
};
</script>
