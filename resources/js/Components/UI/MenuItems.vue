<template>
  <section class="flex flex-col gap-6 sm:gap-8">
    <div class="flex flex-col gap-1.5">
      <label class="text-sm text-slate-600">Listings</label>
      <Link
        v-for="(link, index) in navListingLinks"
        :href="link.routeName ? route(link.routeName) : '#'"
        :key="index"
        class="flex items-center gap-2 p-2 hover:bg-slate-50 cursor-pointer text-[17px] rounded-md hover:border-l-4 transition-all border-lduration-150 hover:border-teal-500"
        :class="{ 'bg-slate-50 border-teal-500 border-l-4': route().current() == link.routeName || route().current(link.routePrefix) == true }"
      >
        <Icon class="text-slate-500 w-5 h-5" :icon="link.icon" />
        <span class="flex-1">{{ link.label }}</span>
      </Link>
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-sm text-slate-600">Professional Experience</label>
      <Link
        v-for="(link, index) in navPersonalDetailsLinks"
        :href="link.routeName ? route(link.routeName) : '#'"
        :key="index"
        class="flex items-center gap-2 p-2 hover:bg-slate-50 cursor-pointer text-[17px] rounded-md hover:border-l-4 transition-all border-lduration-150 hover:border-teal-500"
        :class="{ 'bg-slate-50 border-teal-500 border-l-4': route().current() == link.routeName || route().current(link.routePrefix) == true }"
      >
        <Icon class="text-slate-500 w-5 h-5" :icon="link.icon" />
        <span class="flex-1">{{ link.label }}</span>
      </Link>
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-sm text-slate-600">Job Applications</label>
      <Link
        v-for="(link, index) in navApplicationLinks"
        :href="link.routeName ? route(link.routeName) : '#'"
        :key="index"
        class="flex items-center gap-2 p-2 hover:bg-slate-50 cursor-pointer text-[17px] rounded-md hover:border-l-4 transition-all border-lduration-150 hover:border-teal-500"
        :class="{ 'bg-slate-50 border-teal-500 border-l-4': route().current() == link.routeName || route().current(link.routePrefix) == true }"
      >
        <Icon class="text-slate-500 w-5 h-5" :icon="link.icon" />
        <span class="flex-1">{{ link.label }}</span>
      </Link>
    </div>
  </section>
</template>

<script setup>
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";

const navListingLinks = [
  // { icon: "fluent:window-apps-16-regular", label: "Overview", routeName: "" },
  { icon: "fluent:document-bullet-list-16-regular", label: "Saved Listings", routeName: "job-listing.index", routePrefix: "job-listing.*" },
  { icon: "fluent:tag-16-regular", label: "Tags", routeName: "tag.index" },
];

const navPersonalDetailsLinks = [
  // { icon: "fluent:chart-person-20-regular", label: "Profile", routeName: "account.edit" },
  { icon: "fluent:person-mail-20-regular", label: "Contact Details", routeName: "contact-details.index" },
  { icon: "fluent:briefcase-16-regular", label: "Work Experience", routeName: "work-experience.index" },
  { icon: "fluent:hat-graduation-16-regular", label: "Education", routeName: "education.index" },
  { icon: "solar:pie-chart-outline", label: "Skills", routeName: "skill.index" },
  { icon: "solar:medal-ribbon-linear", label: "Certifications", routeName: "" },
];

const navApplicationLinks = [
  { icon: "fluent:mail-template-20-regular", label: "Cover Letters", routeName: "" },
  { icon: "solar:document-text-linear", label: "Resumes", routeName: "" },
];
</script>
