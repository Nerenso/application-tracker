<template>
  <DashboardLayout title="Tags" :show-top-bar="true">
    <Head title="Tags" />
    <template #actions>
      <XButton color="primary" @click="openAddModal()" class="hidden md:block"
        >Add Tag</XButton
      >
      <div
        @click="openAddModal()"
        class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-500 text-white md:hidden"
      >
        <Icon icon="mi:add" class="" />
      </div>
    </template>

    <section v-if="tags.length == 0" class="w-full p-2">
      <EmptyState>
        <div class="mb-4 flex flex-col gap-4">
          <p class="empty-state-text">
            You have not added any tags yet. Try adding a tag.
          </p>
          <XButton class="mx-auto w-fit" color="primary" @click="openModal"
            >Add New Tag</XButton
          >
        </div>
      </EmptyState>
    </section>

    <section v-else class="w-full overflow-hidden p-2 md:p-6">
      <div
        class="mx-auto mb-20 mt-4 grid w-full max-w-5xl grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3"
      >
        <div v-for="tag in tags" :key="tag.div">
          <TagCard :tag="tag" @edit="openEditModal(tag)" />
        </div>
      </div>
    </section>

    <BaseModal
      :show-modal="showAddTagModal"
      @close="closeModal('showAddTagModal')"
      title="Add New Tag"
      button-text="Add Tag"
      :loading="loading"
      @save="submitTagForm('add')"
    >
      <template #content>
        <form class="mb-6 w-full space-y-6">
          <div class="w-full">
            <BaseLabel label="Tag Name" is-required>
              <XInput
                class="w-full"
                v-model="tagForm.title"
                placeholder="Marketing"
                :required="true"
              />
              <p class="form-error">{{ tagForm.errors.title }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel label="Tag Color" is-required>
              <div class="flex items-center">
                <div v-for="(color, index) in colorLabels" :key="index">
                  <div
                    class="cursor-pointer rounded-full p-[2px]"
                    :class="
                      tagForm.color === color
                        ? activeColorWithRing[color].outline
                        : 'border border-transparent'
                    "
                  >
                    <div
                      class="flex h-6 w-6 items-center justify-center rounded-full"
                      :class="
                        tagForm.color === color
                          ? activeColorWithRing[color].circle
                          : tagColorPickerVariants[color]
                      "
                      @click="tagForm.color = color"
                    >
                      <Icon
                        v-if="tagForm.color == color"
                        icon="fluent:checkmark-12-filled"
                        class="text-white"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </BaseLabel>
          </div>
        </form>
      </template>
    </BaseModal>

    <BaseModal
      :show-modal="showEditTagModal"
      @close="closeModal('showEditTagModal')"
      title="Edit Tag"
      button-text="Save Changes"
      :loading="loading"
      @save="submitTagForm('edit')"
    >
      <template #content>
        <form class="mb-6 w-full space-y-6">
          <div class="w-full">
            <BaseLabel label="Tag Name" is-required>
              <XInput
                class="w-full"
                v-model="tagForm.title"
                placeholder="Marketing"
                :required="true"
              />
              <p class="form-error">{{ tagForm.errors.title }}</p>
            </BaseLabel>
          </div>

          <div class="w-full">
            <BaseLabel label="Tag Color" is-required>
              <div class="flex items-center">
                <div v-for="(color, index) in colorLabels" :key="index">
                  <div
                    class="cursor-pointer rounded-full p-[2px]"
                    :class="
                      tagForm.color === color
                        ? activeColorWithRing[color].outline
                        : 'border border-transparent'
                    "
                  >
                    <div
                      class="flex h-6 w-6 items-center justify-center rounded-full"
                      :class="
                        tagForm.color === color
                          ? activeColorWithRing[color].circle
                          : tagColorPickerVariants[color]
                      "
                      @click="tagForm.color = color"
                    >
                      <Icon
                        v-if="tagForm.color == color"
                        icon="fluent:checkmark-12-filled"
                        class="text-white"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </BaseLabel>
          </div>
        </form>
      </template>
    </BaseModal>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {
  activeColorWithRing,
  colorLabels,
  tagColorPickerVariants,
} from "@/Utils/TagColors";
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
const tagToEdit = ref(null);

const tagForm = useForm({
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
      tagForm.clearErrors();
      showAddTagModal.value = true;
      break;
    case "showEditTagModal":
      tagForm.clearErrors();
      showEditTagModal.value = true;
      break;
    default:
      break;
  }
};

const closeModal = (modal) => {
  switch (modal) {
    case "showAddTagModal":
      showAddTagModal.value = false;

      break;

    case "showEditTagModal":
      showEditTagModal.value = false;
      break;
  }
};

const openEditModal = (tag) => {
  tagToEdit.value = tag;
  tagForm.title = tag.title;
  tagForm.color = tag.color;
  openModal("showEditTagModal");
};

const openAddModal = () => {
  tagForm.title = "";
  tagForm.color = "amber";
  openModal("showAddTagModal");
};

const resetForm = () => {
  setLoading();
  tagForm.title = "";
  tagForm.color = "amber";
};

const submitTagForm = (action) => {
  tagForm.clearErrors();

  if (action == "add") {
    tagForm.post(route("tag.store"), {
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
  } else {
    tagForm.patch(route("tag.update", tagToEdit.value.id), {
      onStart: () => {
        setLoading();
      },
      onSuccess: () => {
        resetForm();
        closeModal("showEditTagModal");
      },
      onError: () => {
        setLoading();
      },
    });
  }
};
</script>
