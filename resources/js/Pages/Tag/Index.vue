<template>
  <DashboardLayout title="Tags" :show-top-bar="true">
    <Head title="Tags" />
    <template #actions>
      <XButton color="primary" @click="openModal('showAddTagModal')" class="hidden md:block">Add Tag</XButton>
      <div @click="openModal('showAddTagModal')" class="w-9 md:hidden h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center">
        <Icon icon="mi:add" class="" />
      </div>
    </template>

    <section v-if="tags.length == 0" class="w-full p-2">
      <EmptyState>
        <div class="flex flex-col gap-4 mb-4">
          <p class="empty-state-text">You have not added any tags yet. Try adding a tag.</p>
          <XButton class="w-fit mx-auto" color="primary" @click="openModal">Add New Tag</XButton>
        </div>
      </EmptyState>
    </section>

    <section v-else class="w-full p-2 md:p-6 overflow-hidden">
      <div class="w-full max-w-5xl mx-auto grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3 mb-20 mt-4">
        <div v-for="tag in tags" :key="tag.div">
          <TagCard :tag="tag" @edit="setSelectedTag(tag)" />
        </div>
      </div>
    </section>

    <BaseModal
      :show-modal="showAddTagModal"
      @close="closeModal('showAddTagModal')"
      title="Add New Tag"
      success-button="Add Tag"
      :loading="loading"
      @save="submitAddTagForm"
    >
      <template #content>
        <form class="w-full space-y-6 mb-6">
          <div class="w-full">
            <BaseLabel label="Tag Name" is-required>
              <XInput class="w-full" v-model="addTagForm.title" placeholder="Marketing" :required="true" />
              <p class="form-error">{{ addTagForm.errors.title }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel label="Tag Color" is-required>
              <div class="flex items-center">
                <div v-for="(color, index) in colorLabels" :key="index">
                  <div
                    class="p-[2px] rounded-full cursor-pointer"
                    :class="addTagForm.color === color ? activeColorWithRing[color].outline : 'border border-transparent'"
                  >
                    <div
                      class="w-6 h-6 rounded-full flex justify-center items-center"
                      :class="addTagForm.color === color ? activeColorWithRing[color].circle : tagColorPickerVariants[color]"
                      @click="addTagForm.color = color"
                    >
                      <Icon v-if="addTagForm.color == color" icon="fluent:checkmark-12-filled" class="text-white" />
                    </div>
                  </div>
                </div>
              </div>
            </BaseLabel>
          </div>
        </form>
      </template>
    </BaseModal>

    <BaseModal :show-modal="showEditTagModal" @close="closeModal('showEditTagModal')"> </BaseModal>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { activeColorWithRing, colorLabels, tagColorPickerVariants } from "@/Utils/TagColors";
import TagCard from "@/Components/Tags/TagCard.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { XButton, XInput } from "@indielayer/ui";
import { onMounted, ref } from "vue";
import BaseModal from "@/Components/UI/BaseModal.vue";
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import { set } from "@vueuse/core";

const loading = ref(false);
const showAddTagModal = ref(false);
const showEditTagModal = ref(false);
const selectedTag = ref(null);

const addTagForm = useForm({
  title: "",
  color: "amber",
});

const setLoading = () => {
  loading.value = !loading.value;
};

const props = defineProps({
  tags: Array,
});

const openModal = (modal) => {
  switch (modal) {
    case "showAddTagModal":
      showAddTagModal.value = true;
      break;

    default:
      break;
  }
};

const closeModal = (modal) => {
  switch (modal) {
    case "showAddTagModal":
      showAddTagModal.value = false;
      setTimeout(() => {
        addTagForm.color = "amber";
      }, 500);
      break;
  }
};

const setSelectedTag = (tag) => {
  console.log(tag);
  selectedTag.value = tag;
};

const resetForm = () => {
  setLoading();
  addTagForm.title = "";
  addTagForm.color = "amber";
};

const submitAddTagForm = () => {
  addTagForm.clearErrors();
  addTagForm.post(route("tag.store"), {
    onStart: () => {
      setLoading();
    },
    onSuccess: () => {
      resetForm();
      closeModal("showAddTagModal");
    },
    onError: () => {
      setLoading();
    },
  });
};
</script>
