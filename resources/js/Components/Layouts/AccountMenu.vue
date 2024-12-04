<template>
  <XPopover
    position="top"
    align="left"
    :dismiss-on-click="false"
    @close="showPopOver = false"
  >
    <button
      @click="showPopOver = !showPopOver"
      class="flex w-full items-center justify-between gap-2 rounded-lg border px-2.5 py-1.5"
    >
      <div class="flex flex-col items-start justify-start">
        <span>
          {{ $page.props.auth.user.name }}
        </span>
        <span class="max-w-[165px] truncate text-xs text-slate-500">{{
          $page.props.auth.user.email
        }}</span>
      </div>
      <Icon
        icon="fluent:chevron-up-16-regular"
        :class="showPopOver ? 'rotate-180' : ''"
        class="transition-all duration-150"
      />
    </button>
    <template #content>
      <div
        v-if="showPopOver"
        class="w-[211px] rounded-lg border bg-white p-2 shadow-lg"
      >
        <nav class="flex w-full flex-col">
          <Link
            :href="route('account.edit')"
            as="button"
            class="flex items-center justify-start gap-1 rounded-md p-2 transition-all duration-150 hover:bg-slate-50"
          >
            <Icon icon="fluent:settings-16-regular" class="h-5 w-5" />
            <span>Settings</span>
          </Link>
          <Link
            method="post"
            :href="route('logout')"
            as="button"
            class="flex items-center justify-start gap-1 rounded-md p-2 transition-all duration-150 hover:bg-slate-50"
          >
            <Icon icon="majesticons:door-exit-line" class="h-5 w-5 p-0.5" />
            <span>Log Out</span>
          </Link>
        </nav>
      </div>
    </template>
  </XPopover>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";
import { XPopover, XPopoverContainer } from "@indielayer/ui";
import { ref } from "vue";

const showPopOver = ref(false);
</script>
