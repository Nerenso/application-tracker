<template>
  <main class="min-h-screen w-full flex bg-slate-50 relative">
    <aside class="p-6 h-[100dvh] sticky top-0 bg-white hidden lg:w-[260px] lg:block shrink-0 border-r">
      <nav class="flex flex-col h-full overflow-hidden">
        <div class="text-xl font-semibold flex items-center gap-1">
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
    <section class="flex flex-col relative w-full">
      <div class="pl-2 pr-4 py-4 h-fit md:h-[91px] flex lg:p-6 bg-white w-full sticky top-0 border-b z-10">
        <div class="flex w-full items-center justify-between">
          <div class="flex items-center gap-0">
            <BaseDrawer :is-visible="showMenu" @close="showMenu = false" position="left" width="sm">
              <aside class="w-full h-full p-6 flex flex-col gap-6 overflow-hidden">
                <div class="text-xl font-semibold flex items-center gap-1">
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
              <Icon class="w-6 h-6 lg:hidden" icon="heroicons-outline:menu-alt-4" />
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
        class="flex items-center fixed bottom-8 right-4 md:bottom-8 md:right-8 bg-white rounded-lg shadow-xl border overflow-hidden px-3 py-2"
        :initial="{ opacity: 0, y: 50 }"
        :animate="{ opacity: 1, y: 0 }"
        :exit="{ opacity: 0, y: 50 }"
        :transition="{ duration: 0.3 }"
      >
        <Icon icon="fluent:checkmark-circle-12-filled" class="w-8 h-8 p-[5px] rounded-md text-emerald-500 bg-emerald-100" />
        <p class="pl-2 pr-4 py-2 text-sm font-medium">{{ successMessage }}</p>
      </Motion>
    </Presence>

    <div v-if="errorMessage" class="fixed bottom-8 right-8 p-4 bg-white rounded-lg shadow-xl border border-l-4 border-red-500">
      <p>{{ page.props.flash.message }}</p>
    </div>
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

const props = defineProps({
  title: String,
  subTitle: String,
  showTopBar: Boolean,
});

const page = usePage();
const showMenu = ref(false);
const showSuccessToast = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

const successMessageProp = computed(() => page.props.flash.success);

const errorMessageProp = computed(() => {
  return page.props.flash.message;
});

let removeSuccessToastEventListener = router.on("finish", () => {
  successMessage.value = successMessageProp.value;

  if (successMessage.value) {
    handleSuccessToast();
  }
});

const handleSuccessToast = () => {
  showSuccessToast.value = true;
  setTimeout(() => {
    showSuccessToast.value = false;
    successMessage.value = null;
  }, 3000);
};

watch(errorMessageProp, (newVal, oldVal) => {
  newVal ?? setErrorMessage(newVal);
});

onUnmounted(() => removeSuccessToastEventListener());

const setErrorMessage = (message) => {
  errorMessage.value = message;
  setTimeout(() => {
    errorMessage.value = null;
  }, 3000);
};

const setShowMenu = () => {
  showMenu.value = !showMenu.value;
};
</script>
