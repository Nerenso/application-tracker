<template>
  <main class="min-h-screen w-full flex bg-slate-50 relative">
    <aside class="p-6 h-screen sticky top-0 bg-white hidden lg:w-[260px] lg:block shrink-0 border-r">
      <nav class="flex flex-col h-full">
        <div class="text-xl font-semibold flex items-center gap-1">
          <Icon class="text-teal-500" icon="fa6-solid:vault" />
          <span>JobVault</span>
        </div>

        <section class="mt-28">
          <MenuItems />
        </section>
        <section class="flex-1 flex flex-col justify-end">
          <AccountMenu />
        </section>
      </nav>
    </aside>
    <section class="flex flex-col relative w-full">
      <div class="pl-2 pr-4 py-4 lg:p-6 bg-white w-full sticky top-0 border-b z-10">
        <div class="max-w-5xl mx-auto flex items-center justify-between sticky top-0">
          <div class="flex items-center gap-0">
            <BaseDrawer :is-visible="showMenu" @close="showMenu = false" position="left" width="sm">
              <div class="w-full h-full p-6 flex flex-col gap-10">
                <div class="text-xl font-semibold flex items-center gap-1">
                  <Icon class="text-teal-500" icon="fa6-solid:vault" />
                  <span>JobVault</span>
                </div>
                <div>
                  <MenuItems />
                </div>
                <section class="flex-1 flex flex-col justify-end">
                  <AccountMenu />
                </section>
              </div>
            </BaseDrawer>
            <button @click="setShowMenu" class="p-2 lg:hidden">
              <Icon class="w-6 h-6 lg:hidden" icon="heroicons-outline:menu-alt-4" />
            </button>
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
import { Motion, Presence } from "motion/vue";
import { Icon } from "@iconify/vue";
import { usePage, router } from "@inertiajs/vue3";
import MenuItems from "@/Components/MenuItems.vue";
import BaseDrawer from "@/Components/BaseDrawer.vue";
import { ref, computed, watch, onUnmounted } from "vue";

const props = defineProps({
  title: String,
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
