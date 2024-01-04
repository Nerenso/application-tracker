<template>
  <XPopover position="top" align="left" :dismiss-on-click="false" @close="showPopOver = false">
    <button @click="showPopOver = !showPopOver" class="flex items-center justify-between gap-2 px-2.5 py-1.5 border w-full rounded-lg">
      <div class="flex flex-col justify-start items-start">
        <span>
          {{ $page.props.auth.user.name }}
        </span>
        <span class="text-xs text-slate-500 truncate">{{ $page.props.auth.user.email }}</span>
      </div>
      <Icon icon="fluent:chevron-up-16-regular" :class="showPopOver ? 'rotate-180' : ''" class="transition-all duration-150" />
    </button>
    <template #content>
      <div v-if="showPopOver" class="p-2 bg-white shadow-lg rounded-lg border w-[211px]">
        <nav class="flex flex-col w-full">
          <Link
            :href="route('account.edit')"
            as="button"
            class="hover:bg-slate-50 transition-all duration-150 rounded-md flex items-center justify-start gap-1 p-2"
          >
            <Icon icon="fluent:settings-16-regular" class="w-5 h-5" />
            <span>Settings</span>
          </Link>
          <Link
            method="post"
            :href="route('logout')"
            as="button"
            class="hover:bg-slate-50 transition-all duration-150 rounded-md flex items-center justify-start gap-1 p-2"
          >
            <Icon icon="majesticons:door-exit-line" class="w-5 h-5 p-0.5" />
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
