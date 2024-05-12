<template>
  <DashboardLayout title="Skills">
    <Head title="Skills" />
    <template #actions>
      <XButton color="primary" @click="openModal" class="hidden md:block">Add Skill</XButton>
      <div @click="openModal" class="w-9 md:hidden h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center">
        <Icon icon="mi:add" class="" />
      </div>
    </template>
    <div class="min-h-screen w-full">
      <section v-if="!skills?.length" class="w-full p-2">
        <EmptyState>
          <div class="flex flex-col gap-4 mb-4">
            <p class="empty-state-text">You haven't added any skills yet. Try adding some.</p>
            <XButton class="w-fit mx-auto" color="primary" @click="openModal">Add New Skill</XButton>
          </div>
        </EmptyState>
      </section>

      <section v-else class="w-full p-2 md:p-6">
        <div class="max-w-5xl w-full mx-auto">
          <div class="my-4 grid grid-cols-1 gap-4">
            <SkillCard v-for="skill in skills" :key="skill.id" :skill="skill" />
          </div>
        </div>
      </section>
    </div>
    <SkillForm modal-type="New" :show-modal="showModal" @close="showModal = false" modal-title="Add New Skill" success-button="Add Skill" />
  </DashboardLayout>
</template>

<script setup>
import SkillCard from "@/Components/Skill/SkillCard.vue";
import SkillForm from "@/Components/Skill/SkillForm.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Icon } from "@iconify/vue";
import { XButton } from "@indielayer/ui";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const showModal = ref(false);

const props = defineProps({
  skills: Object,
});

const openModal = () => {
  showModal.value = true;
};
</script>
