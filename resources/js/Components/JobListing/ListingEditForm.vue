<template>
  <BaseModal
    @close="closeModal"
    :show-modal="showModal"
    title="Edit Job Listing"
    button-text="Save Changes"
    @save="submit"
  >
    <template #content>
      <form class="w-full space-y-4">
        <div>
          <a
            target="_blank"
            class="group mb-2 flex items-center"
            :href="listingInfo?.listing_url"
          >
            <img
              v-if="listingInfo?.img_url && !imageError"
              :src="listingInfo?.img_url"
              alt=""
              class="h-6 w-6 rounded-md object-contain"
              @error="imageError = true"
            />
            <Icon
              v-else
              class="h-6 w-6 object-contain text-slate-600"
              icon="fluent:building-multiple-20-filled"
            />
            <span class="ml-2">{{ listingInfo?.company_name }}</span>
            <Icon
              class="ml-0.5 h-5 w-5 text-slate-400 group-hover:text-teal-500"
              icon="heroicons:arrow-up-right-16-solid"
            />
          </a>
          <h4>{{ listingInfo?.page_title }}</h4>
        </div>
        <div class="my-4 flex w-full items-center justify-between">
          <label class="font-medium">Tags</label>
          <AddTagWidget class="z-50" />
        </div>
        <div class="flex flex-wrap items-center gap-x-1.5 gap-y-2">
          <div v-for="tag in tags" :key="tag.id">
            <div
              v-if="!listingForm.selectedMultiple.includes(tag.id)"
              @click="addToSelected(tag.id)"
              class="cursor-pointer rounded-md px-2.5 py-1.5 text-xs font-semibold"
              :class="colorVariants[tag.color]"
            >
              <p>{{ tag.title }}</p>
            </div>
            <div
              v-if="listingForm.selectedMultiple.includes(tag.id)"
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
            rows="6"
            placeholder="Add your notes about this listing here..."
            adjust-to-text
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
import ContentBox from "@/Components/UI/ContentBox.vue";
import BaseModal from "@/Components/UI/BaseModal.vue";
import { colorVariants, selectedColorVariants } from "@/Utils/TagColors";
import TagListDisplay from "@/Components/Tags/TagListDisplay.vue";
import ActionMenu from "../UI/ActionMenu.vue";
import { Icon } from "@iconify/vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { ref } from "vue";
import BaseLabel from "../UI/BaseLabel.vue";
import { XInput, XTextarea } from "@indielayer/ui";
import AddTagWidget from "../Tags/AddTagWidget.vue";
import { computed } from "vue";
import { watch } from "vue";

dayjs.extend(relativeTime);

const props = defineProps({
  listingInfo: Object,
  tags: Array,
  showModal: Boolean,
});

const emit = defineEmits(["closed"]);

const listingForm = useForm({
  job_link: "",
  selectedMultiple: [],
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
  location: "",
});

const activeTags = computed(() => {
  if (props.listingInfo) {
    return props.listingInfo.tags;
  }
});

watch(activeTags, () => {
  if (activeTags.value) {
    const tagsArr = activeTags.value.map((el) => {
      return el.id;
    });
    listingForm.selectedMultiple = tagsArr;
    listingForm.salary_from = props.listingInfo.salary_from;
    listingForm.salary_to = props.listingInfo.salary_to;
    listingForm.location = props.listingInfo.location;
    listingForm.notes = props.listingInfo.notes;
  } else {
    listingForm.selectedMultiple = [];
  }
});

const closeModal = () => {
  emit("closed");
};

const getSalaryRangeText = () => {
  if (props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `€${props.listingInfo.salary_from.toLocaleString("nl-NL")} - €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else if (!props.listingInfo.salary_from && props.listingInfo.salary_to) {
    return `up to €${props.listingInfo.salary_to.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};

const showDetail = () => {
  router.visit(route("job-listing.show", props.listingInfo.id));
};

const imageError = ref(false);

const addToSelected = (item) => {
  const foundItem = listingForm.selectedMultiple.includes(item);
  if (!foundItem) {
    listingForm.selectedMultiple.push(item);
  }
};

const removeFromSelected = (item) => {
  const foundItem = listingForm.selectedMultiple.includes(item);
  if (foundItem) {
    const newArray = [...listingForm.selectedMultiple].filter(
      (element) => element !== item,
    );
    listingForm.selectedMultiple = newArray;
  }
};

const setLoading = () => {
  loading.value = !loading.value;
};

const resetForm = () => {
  listingForm.job_link = "";
  listingForm.selectedMultiple = [];
  listingForm.notes = "";
  listingForm.salary_from = null;
  listingForm.salary_to = null;
  listingForm.contact_name = "";
  listingForm.contact_phone = "";
  listingForm.contact_email = "";
  listingForm.location = "";
  showModal.value = false;
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
