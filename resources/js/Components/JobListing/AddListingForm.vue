<template>
  <BaseModal
    @close="closeModal"
    :show-modal="showModal"
    title="Add New Job Listing"
    :loading="loading"
    button-text="Add Listing"
    @save="submit"
  >
    <template #content>
      <XTabGroup
        variant="block"
        v-model="listingForm.add_listing_mode"
        class="pb-4"
        grow
      >
        <XTab value="automated" label="AI Powered"></XTab>
        <XTab value="manual" label="Manual"></XTab>
      </XTabGroup>
      <form class="w-full space-y-4">
        <label v-if="listingForm.add_listing_mode === 'manual'" class="w-full">
          <div class="mb-1 flex gap-0.5 font-medium">
            <p>Job Listing Text</p>
            <span class="text-red-500">*</span>
          </div>
          <div class="mb-4">
            <XTextarea
              :adjust-to-text="false"
              class="w-full"
              rows="4"
              placeholder="Paste the text of the job listing you found here."
              v-model="listingForm.pasted_listing_text"
            />
            <p v-if="listingForm.errors.pasted_listing_text" class="form-error">
              {{ listingForm.errors.pasted_listing_text }}
            </p>
          </div>
        </label>

        <label>
          <div class="mb-1 flex gap-0.5 font-medium">
            <p>Job Link</p>
            <span class="text-red-500">*</span>
          </div>
          <XInput
            class="w-full"
            id="job_link"
            v-model="listingForm.job_link"
            placeholder="https://google.com"
            :required="true"
          />
          <p class="form-error">{{ listingForm.errors.job_link }}</p>
        </label>
        <div class="my-4 flex w-full items-center justify-between">
          <label class="font-medium">Tags</label>
          <AddTagWidget class="z-50" />
        </div>
        <div class="flex flex-wrap items-center gap-x-1.5 gap-y-2">
          <div v-for="tag in tags" :key="tag.id">
            <div
              v-if="!listingForm.selectedTags.includes(tag.id)"
              @click="addToSelected(tag.id)"
              class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold"
              :class="colorVariants[tag.color]"
            >
              <p>{{ tag.title }}</p>
            </div>
            <div
              v-if="listingForm.selectedTags.includes(tag.id)"
              @click="removeFromSelected(tag.id)"
              class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold text-white"
              :class="selectedColorVariants[tag.color]"
            >
              <p>{{ tag.title }}</p>
            </div>
          </div>
          <div
            v-if="!tags.length"
            class="flex w-full items-center justify-center rounded-lg border border-dashed border-slate-300 p-6 text-sm text-slate-500"
          >
            <p>
              You haven't added any tags yet, click on the 'plus' icon to add
              tags.
            </p>
          </div>
        </div>
        <div>
          <XTextarea
            :adjust-to-text="false"
            label="Notes"
            class="w-full"
            rows="4"
            placeholder="Add your notes about this listing here..."
            v-model="listingForm.notes"
          />
          <p class="form-error">{{ listingForm.errors.notes }}</p>
        </div>
        <div class="flex w-full items-center gap-2">
          <section class="w-full">
            <XInput
              type="number"
              label="Min. Salary"
              placeholder="2.000"
              class="w-full"
              v-model="listingForm.salary_from"
            />
            <p class="form-error">{{ listingForm.errors.salary_from }}</p>
          </section>

          <section class="w-full">
            <XInput
              type="number"
              label="Max. Salary"
              placeholder="3.500"
              v-model="listingForm.salary_to"
              class="w-full"
            />
            <p class="form-error">{{ listingForm.errors.salary_to }}</p>
          </section>
        </div>
        <div
          class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-2 lg:grid-cols-1"
        >
          <section>
            <XInput
              label="Location"
              placeholder="Amsterdam"
              class="w-full"
              v-model="listingForm.location"
            />
            <p class="form-error">{{ listingForm.errors.location }}</p>
          </section>
        </div>
      </form>
    </template>
  </BaseModal>
</template>

<script setup>
import { XInput, XTab, XTabGroup, XTextarea } from "@indielayer/ui";
import BaseModal from "@/Components/UI/BaseModal.vue";
import AddTagWidget from "@/Components/Tags/AddTagWidget.vue";
import { colorVariants, selectedColorVariants } from "@/Utils/TagColors";
import { useForm } from "@inertiajs/vue3";
import { useUserStore } from "@/State/UserStore";
import { computed, ref } from "vue";
import { useUIStore } from "@/State/UIStore";
import { watch } from "vue";

const userStore = useUserStore();
const uiStore = useUIStore();
const showModal = computed(() => uiStore.state.showAddListingForm);
const loading = ref(false);

const tags = computed(() => userStore.state.userTags);

const listingForm = useForm({
  add_listing_mode: null,
  pasted_listing_text: "",
  job_link: "",
  selectedTags: [],
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
  location: "",
});

watch(showModal, (newValue) => {
  if (newValue) {
    setTimeout(() => {
      listingForm.add_listing_mode = "automated";
    }, 0);
    listingForm.selectedTags = [];
    listingForm.clearErrors();
  }
});

const closeModal = () => {
  uiStore.actions.setShowAddListingForm(false);
};

const addToSelected = (item) => {
  const foundItem = listingForm.selectedTags.includes(item);
  if (!foundItem) {
    listingForm.selectedTags.push(item);
  }
};

const removeFromSelected = (item) => {
  const foundItem = listingForm.selectedTags.includes(item);
  if (foundItem) {
    const newArray = [...listingForm.selectedTags].filter(
      (element) => element !== item,
    );
    listingForm.selectedTags = newArray;
  }
};

const setLoading = () => {
  loading.value = !loading.value;
};

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.pasted_listing_text = "";
  listingForm.selectedTags = [];
  listingForm.notes = "";
  listingForm.salary_from = null;
  listingForm.salary_to = null;
  listingForm.contact_name = "";
  listingForm.contact_phone = "";
  listingForm.contact_email = "";
  listingForm.location = "";
  uiStore.actions.setShowAddListingForm(false);
};

const submit = () => {
  listingForm.clearErrors();
  listingForm.post(route("job-listing.store"), {
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
