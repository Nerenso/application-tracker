<template>
  <Head title="Home" />
  <main class="min-h-screen w-full flex flex-col bg-slate-100">
    <nav class="w-full">
      <div class="mx-auto max-w-5xl w-full p-4 flex items-center justify-between">
        <h1 class="text-4xl font-bold">
          <a href="#">Logo</a>
        </h1>
        <div class="flex items-center justify-between gap-4">
          <Link :href="route('login')">Login</Link>
          <Link :href="route('register')">Register</Link>
          <XButton color="secondary">Get Started</XButton>
        </div>
      </div>
    </nav>

    <section class="flex-1 w-full">
      <div class="mx-auto max-w-5xl w-full p-4">CONTENT</div>
    </section>
  </main>
</template>

<script setup>
import { XButton } from "@indielayer/ui";
import { Head, Link } from "@inertiajs/vue3";
</script>
