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

    <div class="max-w-5xl mx-auto w-full grid grid-cols-1">
      <JobListing :listing-info="listingInfo1" />
      <JobListing :listing-info="listingInfo2" />
    </div>
  </main>
</template>

<script setup>
import JobListing from "@/Components/JobListing.vue";
import { XButton } from "@indielayer/ui";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps(["pageTitle", "desc", "companyName", "info", "img", "listingInfo1", "listingInfo2"]);

console.log(props.info);
</script>
