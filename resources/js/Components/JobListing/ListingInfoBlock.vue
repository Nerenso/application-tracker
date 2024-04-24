<template>
  <ContentBox class="centered-container">
    <main class="p-4 sm:p-6">
      <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-medium">Listing Information</h4>

        <button v-if="!editMode" class="text-slate-600" as="button" @click="editMode = !editMode">
          <Icon icon="fluent:edit-12-regular" class="w-4 h-4" />
        </button>
        <div v-else class="flex items-center gap-2">
          <button class="text-slate-600" as="button" @click="submitListingInfoUpdate()">
            <Icon icon="fluent:save-16-regular" class="w-5 h-5" />
          </button>
          <button class="text-slate-600" as="button" @click="editMode = false">
            <Icon icon="fluent:dismiss-16-filled" class="w-4 h-4" />
          </button>
        </div>
      </div>

      <section v-if="!editMode" class="flex flex-col gap-4 sm:gap-8">
        <div class="flex flex-col sm:flex-row gap-4 sm:gap-12">
          <section class="flex gap-1.5 flex-col sm:gap-2 text-[15px]">
            <div v-if="listing.location" class="flex gap-1 items-center">
              <Icon icon="fluent:location-12-regular" class="card-label" />
              <p>{{ listing.location }}</p>
            </div>

            <div v-if="getSalaryRangeText()" class="flex gap-1 items-center">
              <Icon icon="fluent:money-hand-16-regular" class="card-label" />
              <p class="">{{ getSalaryRangeText() }}</p>
            </div>

            <div class="flex gap-1 items-center">
              <Icon icon="fluent:clock-12-regular" class="card-label" />
              <p>{{ "Added " + dayjs(listing.created_at).fromNow() }}</p>
            </div>
          </section>
          <section class="flex gap-1.5 flex-col sm:gap-2 text-[15px]">
            <div v-if="listing.contact_name" class="flex gap-1 items-center">
              <Icon icon="fluent:person-12-regular" class="text-slate-500" />
              <p class="">{{ listing.contact_name }}</p>
            </div>

            <div v-if="listing.contact_phone" class="flex gap-1 items-center">
              <Icon icon="fluent:phone-12-regular" class="text-slate-500" />
              <!-- <p class="">{{ listing.contact_phone }}</p> -->
              <a v-if="listing.contact_phone" :href="`tel:${listing.contact_phone}`">{{ listing.contact_phone }}</a>
            </div>

            <div v-if="listing.contact_email" class="flex gap-1 items-center">
              <Icon icon="fluent:mail-16-regular" class="text-slate-500" />
              <a :href="`mailto:${listing.contact_email}`">{{ listing.contact_email }}</a>
            </div>
          </section>
        </div>
        <div>
          <BaseLabel label="Notes" />
          <div v-if="listing.notes" class="whitespace-pre-wrap" v-html="listing.notes"></div>
          <p v-else class="text-slate-500">No notes to show</p>
        </div>
      </section>
      <form class="w-full gap-4 flex flex-col" v-if="editMode">
        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-2 w-full">
          <section class="w-full">
            <XInput type="text" label="Location" placeholder="Amsterdam" class="w-full" v-model="listingInfoForm.location" />
            <p class="form-error">{{ listingInfoForm.errors.location }}</p>
          </section>
          <div class="w-full flex gap-2">
            <section class="w-full">
              <XInput type="number" label="Min. Salary" placeholder="2.000" class="w-full" v-model="listingInfoForm.salary_from" />
              <p class="form-error">{{ listingInfoForm.errors.salary_from }}</p>
            </section>

            <section class="w-full">
              <XInput type="number" label="Max. Salary" placeholder="3.500" v-model="listingInfoForm.salary_to" class="w-full" />
              <p class="form-error">{{ listingInfoForm.errors.salary_to }}</p>
            </section>
          </div>
        </div>
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-2">
          <section>
            <XInput label="Contact Name" placeholder="John Doe" class="w-full" v-model="listingInfoForm.contact_name" />
            <p class="form-error">{{ listingInfoForm.errors.contact_name }}</p>
          </section>

          <section>
            <XInput label="Phone" placeholder="06-12345678" class="w-full" v-model="listingInfoForm.contact_phone" />
            <p class="form-error">{{ listingInfoForm.errors.contact_phone }}</p>
          </section>

          <section>
            <XInput label="E-mail" placeholder="john@google.com" class="w-full" v-model="listingInfoForm.contact_email" />
            <p class="form-error">{{ listingInfoForm.errors.contact_email }}</p>
          </section>
        </div>
        <div class="w-full flex-1">
          <XTextarea
            class="w-full"
            label="Notes"
            :adjust-to-text="false"
            rows="6"
            placeholder="Add your notes about this listing here..."
            v-model="listingInfoForm.notes"
          />
          <p class="form-error">{{ listingInfoForm.errors.notes }}</p>
        </div>
      </form>
    </main>
  </ContentBox>
</template>

<script setup>
import { ref } from "vue";
import ContentBox from "../UI/ContentBox.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { Icon } from "@iconify/vue";
import { XInput, XTextarea } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import BaseLabel from "../UI/BaseLabel.vue";

dayjs.extend(relativeTime);

const props = defineProps({
  listing: Object,
});

const listingInfoForm = useForm({
  notes: "",
  location: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
});

onMounted(() => {
  listingInfoForm.location = props.listing.location;
  listingInfoForm.notes = props.listing.notes;
  listingInfoForm.salary_from = props.listing.salary_from;
  listingInfoForm.salary_to = props.listing.salary_to;
  listingInfoForm.contact_name = props.listing.contact_name;
  listingInfoForm.contact_phone = props.listing.contact_phone;
  listingInfoForm.contact_email = props.listing.contact_email;
});

const editMode = ref(false);

const submitListingInfoUpdate = () => {
  listingInfoForm.patch(route("job-listing.update", props.listing.id), {
    onSuccess: () => (editMode.value = false),
    preserveScroll: true,
  });
};

const getSalaryRangeText = () => {
  if (props.listing.salary_from && props.listing.salary_to) {
    return `€${props.listing.salary_from.toLocaleString("nl-NL")} - €${props.listing.salary_to.toLocaleString("nl-NL")}`;
  } else if (!props.listing.salary_from && props.listing.salary_to) {
    return `up to €${props.listing.salary_to.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};
</script>
