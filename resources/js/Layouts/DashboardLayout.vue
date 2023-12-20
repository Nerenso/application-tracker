<template>
  <main class="min-h-screen w-full flex bg-slate-50 relative">
    <aside class="p-6 h-screen sticky top-0 bg-white hidden lg:w-[300px] lg:block shrink-0 border-r">
      <nav class="flex flex-col">
        <div class="text-2xl font-semibold flex items-center gap-1">
          <Icon class="text-teal-500" icon="fa6-solid:vault" />
          <span>JobVault</span>
        </div>
      </nav>
    </aside>
    <section class="flex flex-col relative w-full">
      <!-- <nav class="bg-white p-6 flex items-center w-full justify-between border-b">
        <div>Logo</div>
        <Dropdown align="right" width="48">
          <template #trigger>
            <span class="inline-flex rounded-md">
              <button
                type="button"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
              >
                {{ $page.props.auth.user.name }}

                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
            <DropdownLink :href="route('logout')" method="post" as="button"> Log Out </DropdownLink>
          </template>
        </Dropdown>
      </nav> -->
      <div class="px-4 py-4 lg:p-6 bg-white w-full sticky top-0 border-b">
        <div class="max-w-5xl mx-auto flex items-center justify-between sticky top-0">
          <div class="flex items-center gap-4">
            <Icon class="w-6 h-6" icon="heroicons-outline:menu-alt-4" />
            <h4>
              {{ title }}
            </h4>
          </div>
          <div class="flex items-center gap-4">
            <slot name="actions" />
          </div>
        </div>
      </div>
      <div class="overflow-y-scroll">
        <slot />
      </div>
    </section>
  </main>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const props = defineProps({
  title: String,
});

const navLinks = [
  { icon: "fluent:chart-person-20-regular", label: "Profile" },
  { icon: "fluent:tag-16-regular", label: "Profile" },
];
</script>
