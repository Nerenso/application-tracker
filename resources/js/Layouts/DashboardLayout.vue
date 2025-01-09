<template>
  <main class="relative flex min-h-screen w-full bg-slate-50">
    <aside
      class="sticky top-0 hidden h-[100dvh] shrink-0 border-r bg-white p-6 lg:block lg:w-[260px]"
    >
      <nav class="flex h-full flex-col overflow-hidden">
        <div class="flex items-center gap-1 text-xl font-semibold">
          <AppLogo class="w-[112px]" />
        </div>

        <section class="mt-14 flex-1 overflow-y-auto">
          <MenuItems />
        </section>
        <section class="flex flex-col justify-end">
          <AccountMenu />
        </section>
      </nav>
    </aside>
    <section class="relative flex w-full flex-col">
      <div
        class="sticky top-0 z-10 flex h-fit w-full border-b bg-white py-4 pl-2 pr-4 md:h-[91px] lg:p-6"
      >
        <div class="flex w-full items-center justify-between">
          <div class="flex items-center gap-0">
            <BaseDrawer
              :is-visible="showMenu"
              @close="showMenu = false"
              position="left"
              width="sm"
            >
              <aside
                class="flex h-full w-full flex-col gap-6 overflow-hidden p-6"
              >
                <div class="flex items-center gap-1 text-xl font-semibold">
                  <AppLogo class="w-[112px]" />
                </div>
                <div class="flex-1 overflow-y-auto">
                  <MenuItems />
                </div>
                <section class="flex flex-col justify-end">
                  <AccountMenu />
                </section>
              </aside>
            </BaseDrawer>
            <button @click="setShowMenu" class="p-2 lg:hidden">
              <Icon
                class="h-6 w-6 lg:hidden"
                icon="heroicons-outline:menu-alt-4"
              />
            </button>
            <h4 class="flex items-center gap-2">
              {{ title }}
              <span class="text-sm font-normal">{{ subTitle }}</span>
            </h4>
            <slot name="top-bar"></slot>
          </div>
          <div class="flex items-center gap-4">
            <slot name="actions" />
          </div>
        </div>
      </div>
      <div class="overflow-y-auto">
        <slot />
      </div>
    </section>
    <Presence>
      <Motion
        v-if="showSuccessToast"
        class="fixed bottom-8 right-4 flex items-center overflow-hidden rounded-lg border bg-white px-3 py-2 shadow-xl md:bottom-8 md:right-8"
        :initial="{ opacity: 0, y: 50 }"
        :animate="{ opacity: 1, y: 0 }"
        :exit="{ opacity: 0, y: 50 }"
        :transition="{ duration: 0.3 }"
      >
        <Icon
          icon="fluent:checkmark-circle-12-filled"
          class="h-8 w-8 rounded-md bg-emerald-100 p-[5px] text-emerald-500"
        />
        <p class="py-2 pl-2 pr-4 text-sm font-medium">{{ successMessage }}</p>
      </Motion>
    </Presence>

    <BaseModal
      :show-modal="showErrorToast"
      :custom-footer="true"
      title="Error"
      @close="handleDismissErrorToast()"
    >
      <template #content>
        <div
          class="flex flex-col items-start gap-4 pb-6 pt-2 sm:flex-row sm:items-center sm:gap-6"
        >
          <Icon
            icon="fluent:warning-16-filled"
            class="h-8 w-8 flex-shrink-0 rounded-md bg-rose-100 p-1 text-rose-500 sm:h-16 sm:w-16 sm:p-2"
          />
          <p class="max-w-screen-sm">
            {{ errorMessage }}
          </p>
        </div>
      </template>
    </BaseModal>
  </main>
</template>

<script setup>
import AccountMenu from "@/Components/Layouts/AccountMenu.vue";
import MenuItems from "@/Components/UI/MenuItems.vue";
import BaseDrawer from "@/Components/UI/BaseDrawer.vue";
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Motion, Presence } from "motion/vue";
import { Icon } from "@iconify/vue";
import { usePage, router } from "@inertiajs/vue3";
import { ref, computed, watch, onUnmounted } from "vue";
import BaseModal from "@/Components/UI/BaseModal.vue";

const props = defineProps({
  title: String,
  subTitle: String,
  showTopBar: Boolean,
});

const page = usePage();
const showMenu = ref(false);
const showSuccessToast = ref(false);
const showErrorToast = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

const successMessageProp = computed(() => page.props.flash.success);

const errorMessageProp = computed(() => page.props.flash.error);

let removeFlashEventListener = router.on("finish", () => {
  successMessage.value = successMessageProp.value;
  errorMessage.value = errorMessageProp.value;

  if (successMessage.value) {
    handleSuccessToast();
  }

  if (errorMessage.value) {
    handleShowErrorToast(errorMessage.value);
  }
});

const handleSuccessToast = () => {
  showSuccessToast.value = true;
  setTimeout(() => {
    showSuccessToast.value = false;
    successMessage.value = null;
  }, 3000);
};

onUnmounted(() => removeFlashEventListener());

const handleShowErrorToast = (message) => {
  errorMessage.value = message;
  showErrorToast.value = true;
};

const handleDismissErrorToast = () => {
  showErrorToast.value = false;
};

const setShowMenu = () => {
  showMenu.value = !showMenu.value;
};
</script>
