<template>
  <nav
    class="fixed z-50 w-full bg-white px-4 py-4 transition-all duration-150 lg:py-6"
    :class="
      !scrollPositionAtTop || showMenu
        ? 'shadow-lg shadow-black/5'
        : 'shadow-none'
    "
  >
    <section class="mx-auto w-full max-w-6xl transition-all duration-300">
      <div class="flex w-full items-center justify-between">
        <Link href="/"> <AppLogo mode="light" class="w-[112px]" /></Link>
        <div class="hidden items-center gap-8 md:flex">
          <Link
            v-for="link in navLinks"
            :key="link.name"
            :href="link.route"
            class="font-medium transition-all duration-150 hover:text-teal-500"
            >{{ link.name }}</Link
          >
        </div>
        <div class="hidden items-center font-medium md:flex md:gap-4">
          <Link
            :href="route('login')"
            class="transition-all duration-150 hover:text-teal-500"
            >Login</Link
          >
          <Link
            :href="route('register')"
            class="rounded-lg bg-slate-900 px-4 py-2 text-white transition-all duration-150 hover:bg-slate-700"
            >Sign Up</Link
          >
        </div>
        <div class="md:hidden">
          <Icon
            v-if="!showMenu"
            icon="solar:hamburger-menu-linear"
            class="h-8 w-8 text-slate-600"
            @click="showMenu = !showMenu"
          />
          <Icon
            v-else
            icon="carbon:close-large"
            class="h-8 w-8 p-0.5 text-slate-600"
            @click="showMenu = !showMenu"
          />
        </div>
      </div>
      <menu
        class="w-full overflow-hidden transition-all duration-300 ease-out"
        :class="showMenu ? 'h-[380px]' : 'h-0'"
      >
        <Transition
          enter-from-class="opacity-0 translate-y-10"
          enter-to-class="opacity-100 translate-y-0"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 translate-y-10"
        >
          <div
            v-show="showMenu"
            class="mt-10 flex w-full flex-col items-center gap-4 text-2xl font-medium transition-all duration-300 ease-out md:hidden"
          >
            <Link
              v-for="link in navLinks"
              :key="link.name"
              :href="link.route"
              class="transition-all duration-150 hover:text-teal-500"
              >{{ link.name }}</Link
            >
            <!-- <Link
              :href="route('login')"
              class="transition-all duration-150 hover:text-teal-500"
              >Contact</Link
            >
            <Link
              :href="route('login')"
              class="transition-all duration-150 hover:text-teal-500"
              >Pricing</Link
            > -->

            <div
              class="mt-4 flex w-full flex-col items-center gap-4 text-base font-medium md:hidden md:gap-4"
            >
              <Link
                :href="route('login')"
                class="w-full rounded-lg bg-slate-100 px-4 py-3 text-center transition-all duration-150 hover:text-teal-500"
                >Login</Link
              >
              <Link
                :href="route('register')"
                class="w-full rounded-lg bg-slate-900 px-4 py-3 text-center text-white transition-all duration-150 hover:bg-slate-700"
                >Sign Up</Link
              >
            </div>
          </div>
        </Transition>
      </menu>
    </section>
  </nav>

  <Teleport to="body">
    <div
      class="fixed top-0 z-40 h-dvh w-full bg-slate-900/0 transition-colors duration-200"
      :class="
        showMenu ? 'pointer-events-auto bg-slate-900/45' : 'pointer-events-none'
      "
      @click="showMenu = false"
    ></div>
  </Teleport>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { navLinks } from "@/Utils/Marketing/LandingPage";
import { useWindowScroll } from "@vueuse/core";
import { watch, computed, ref } from "vue";
import { Icon } from "@iconify/vue";
import AppLogo from "@/Components/UI/AppLogo.vue";

const showMenu = ref(false);
const scrollPositionAtTop = ref(true);

const { y } = useWindowScroll();

const scrollPosY = computed(() => y.value);

watch(scrollPosY, () => {
  if (scrollPosY.value > 30 && scrollPositionAtTop.value) {
    scrollPositionAtTop.value = false;
  } else if (scrollPosY.value < 30 && !scrollPositionAtTop.value) {
    scrollPositionAtTop.value = true; // scroll position at the top of the page
  }
});
</script>
