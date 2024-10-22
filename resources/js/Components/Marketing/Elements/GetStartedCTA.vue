<template>
  <section
    class="relative mx-auto h-[500px] w-full max-w-6xl overflow-hidden rounded-2xl bg-[url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=3269&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center shadow-2xl shadow-teal-900/60 md:h-[600px]"
  >
    <div
      class="absolute h-full w-full bg-gradient-to-b from-teal-950/75 to-slate-800/50"
    ></div>

    <div
      class="relative z-20 mx-auto flex h-full w-full max-w-md flex-col items-center justify-center p-6"
    >
      <AppLogo mode="dark" class="mb-12 w-[130px]" />
      <p
        class="mb-12 text-center text-3xl font-semibold text-white md:text-5xl lg:text-5xl"
      >
        Ready to take your career to the next level?
      </p>
      <Link
        :href="route('register')"
        class="rounded-lg bg-teal-500 px-6 py-3 text-lg font-semibold text-white backdrop-blur-md duration-200 hover:bg-teal-600"
      >
        Try Jobdeck Today
      </Link>
    </div>
  </section>
</template>

<script setup>
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>
