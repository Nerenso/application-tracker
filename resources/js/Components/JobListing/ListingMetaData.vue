<template>
  <section v-if="hasMetaData" class="overflow-hidden px-4">
    <div
      class="flex flex-nowrap gap-2 overflow-x-auto text-xs text-slate-900 sm:flex-row sm:items-center sm:gap-4"
    >
      <div
        v-if="listing.location"
        class="flex items-center gap-0.5"
        :class="metaInfoClasses"
      >
        <Icon icon="fluent:location-12-regular" class="card-label" />
        <p>{{ listing.location }}</p>
      </div>

      <div
        v-if="getSalaryRangeText()"
        class="flex items-center gap-0.5"
        :class="metaInfoClasses"
      >
        <Icon icon="fluent:money-hand-16-regular" class="card-label" />
        <p class="">{{ getSalaryRangeText() }}</p>
      </div>

      <div
        v-if="listing.contact_name"
        class="flex items-center gap-0.5"
        :class="metaInfoClasses"
      >
        <Icon icon="fluent:person-12-regular" class="card-label" />
        <p class="">{{ listing.contact_name }}</p>
      </div>

      <div
        v-if="listing.contact_phone"
        class="flex items-center gap-0.5"
        :class="metaInfoClasses"
      >
        <Icon icon="fluent:phone-12-regular" class="card-label" />
        <a
          v-if="listing.contact_phone"
          :href="`tel:${listing.contact_phone}`"
          >{{ listing.contact_phone }}</a
        >
      </div>

      <div
        v-if="listing.contact_email"
        class="flex items-center gap-1"
        :class="metaInfoClasses"
      >
        <Icon icon="fluent:mail-12-regular" class="card-label" />
        <a :href="`mailto:${listing.contact_email}`">{{
          listing.contact_email
        }}</a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { computed } from "vue";

const props = defineProps({
  listing: Object,
});

const metaInfoClasses =
  "pl-2 pr-3 py-2 bg-slate-100/70 rounded-md flex-shrink-0";

const getSalaryRangeText = () => {
  if (props.listing.salary_from && props.listing.salary_to) {
    return `€${props.listing.salary_from.toLocaleString("nl-NL")} - €${props.listing.salary_to.toLocaleString("nl-NL")}`;
  } else if (!props.listing.salary_from && props.listing.salary_to) {
    return `up to €${props.listing.salary_to.toLocaleString("nl-NL")}`;
  } else {
    return null;
  }
};

const hasMetaData = computed(() => {
  return Boolean(
    props.listing.location ||
      props.listing.salary_from ||
      props.listing.salary_to ||
      props.listing.contact_name ||
      props.listing.contact_phone ||
      props.listing.contact_email,
  );
});
</script>
