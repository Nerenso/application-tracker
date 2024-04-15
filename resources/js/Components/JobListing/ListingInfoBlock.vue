<template>
  <ContentBox class="centered-container">
    <main class="p-6">
      <div class="flex items-center justify-between">
        <h4 class="">Listing Information</h4>

        <button v-if="!editMode" class="text-slate-600" as="button" @click="editMode = !editMode">
          <Icon icon="fluent:edit-20-filled" class="w-4 h-4" />
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
      <p class="mt-1 mb-3 text-sm text-gray-600 dark:text-gray-400">Add notes and information you found about this listing.</p>

      <section v-if="!editMode" class="flex flex-col gap-8">
        <div>
          <label class="card-label">Notes</label>
          <div v-if="listing.notes" class="whitespace-pre-wrap" v-html="listing.notes"></div>
          <p v-else class="text-slate-500">No notes to show</p>
        </div>
        <div class="flex gap-6 justify-between md:justify-normal">
          <article>
            <label class="card-label">Min Salary</label>
            <div class="flex items-center gap-1">
              <p class="font-medium" :class="{ 'text-slate-500 ': !listing.salary_from }">
                {{ listing.salary_from ? "€" + listing.salary_from.toLocaleString("nl-NL") : "-" }}
              </p>
            </div>
          </article>
          <article class="">
            <label class="card-label text-right md:text-left">Max Salary</label>
            <div class="w-full text-right md:text-left">
              <p class="font-medium" :class="{ ' text-slate-500': !listing.salary_to }">
                {{ listing.salary_to ? "€" + listing.salary_to.toLocaleString("nl-NL") : "-" }}
              </p>
            </div>
          </article>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap gap-6">
          <article>
            <label class="card-label">Contact Name</label>
            <div class="flex items-center gap-1">
              <p class="" :class="{ 'text-slate-500 ': !listing.contact_name }">
                {{ listing.contact_name ?? "-" }}
              </p>
            </div>
          </article>
          <article>
            <label class="card-label">Contact Phone</label>
            <div class="flex items-center gap-1">
              <a v-if="listing.contact_phone" :href="`tel:${listing.contact_phone}`">{{ listing.contact_phone }}</a>
              <p v-else class="text-slate-500">-</p>
            </div>
          </article>
          <article>
            <label class="card-label">Contact Email</label>
            <div class="flex items-center gap-1">
              <p v-if="!listing.contact_email" class="font-medium" :class="{ ' text-slate-500': !listing.contact_email }">-</p>
              <a :href="`mailto:${listing.contact_email}`">{{ listing.contact_email }}</a>
            </div>
          </article>
        </div>
      </section>
      <form class="w-full gap-4 flex flex-col" v-if="editMode">
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
        <div class="flex items-center gap-2 w-full">
          <section class="w-full">
            <XInput type="number" label="Min. Salary" placeholder="2.000" class="w-full" v-model="listingInfoForm.salary_from" />
            <p class="form-error">{{ listingInfoForm.errors.salary_from }}</p>
          </section>

          <section class="w-full">
            <XInput type="number" label="Max. Salary" placeholder="3.500" v-model="listingInfoForm.salary_to" class="w-full" />
            <p class="form-error">{{ listingInfoForm.errors.salary_to }}</p>
          </section>
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
      </form>
    </main>
  </ContentBox>
</template>

<script setup>
import { ref } from "vue";
import ContentBox from "../UI/ContentBox.vue";
import { Icon } from "@iconify/vue";
import { XInput, XTextarea } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
  listing: Object,
});

const listingInfoForm = useForm({
  notes: "",
  salary_from: null,
  salary_to: null,
  contact_name: "",
  contact_phone: "",
  contact_email: "",
});

onMounted(() => {
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
  });
};
</script>

<style lang="scss" scoped></style>
