<template>
  <div
    v-if="listing.status === 'added' || !listing.status"
    class="flex items-center gap-1"
  >
    <Icon icon="fluent:clock-12-regular" class="text-base text-slate-800" />
    <p>{{ "Added " + dayjs(listing.created_at).fromNow() }}</p>
  </div>
  <article v-else class="flex">
    <div
      class="flex w-fit items-center justify-center gap-0.5 rounded-md border border-dashed px-1 py-0.5 text-xs font-medium"
      :class="statusData[listing.status].colorClasses"
    >
      <Icon icon="f7:status" class="h-4 w-4" />
      <span>{{ statusData[listing.status].label }}</span>
    </div>
    <div class="px-2 py-1">
      <span class="helper-text-xs">{{
        dayjs(listing.status_updated_at).fromNow()
      }}</span>
    </div>
  </article>
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
});
</script>
