<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div>
      <Link href="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
      </Link>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
      <slot />
      <div v-if="errorMessage" class="fixed bottom-8 right-8 p-4 bg-white rounded-lg shadow-xl border border-l-4 border-red-500">
        <p>{{ page.props.flash.message }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

const page = usePage();

const errorMessage = ref(null);

const errorMessageProp = computed(() => {
  return page.props.flash.message;
});

watch(errorMessageProp, (newVal, oldVal) => {
  newVal ?? setErrorMessage(newVal);
});

const setErrorMessage = (message) => {
  errorMessage.value = message;
  setTimeout(() => {
    errorMessage.value = null;
  }, 3000);
};
</script>
