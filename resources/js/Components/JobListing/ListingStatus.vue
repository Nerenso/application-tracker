<template>
  <section class="text-sm">
    <article
      v-if="listing.status === 'added' || !listing.status"
      class="flex items-center gap-1"
    >
      <Icon icon="fluent:clock-12-regular" class="text-base text-slate-800" />
      <p class="text-slate-600">
        {{ "Added " + dayjs(listing.created_at).fromNow() }}
      </p>
    </article>
    <article v-else class="flex items-center">
      <div
        class="flex w-fit items-center justify-center gap-1 rounded-md font-semibold"
        :class="statusData[listing.status].colorClasses"
      >
        <Icon icon="f7:status" class="h-4 w-4" />
        <span>{{ statusData[listing.status].label }}</span>
      </div>
      <div class="flex items-center pl-1 text-slate-600">
        <span class="">{{ dayjs(listing.status_updated_at).fromNow() }}</span>
      </div>
    </article>
  </section>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { statusData } from "@/Utils/ListingStatusProperties";

dayjs.extend(relativeTime);

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
  onDetailPage: {
    type: Boolean,
    default: false,
  },
});
</script>
