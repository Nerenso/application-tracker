<template>
  <nav class="flex gap-6 w-full">
    <!-- <Link
      v-for="(link, index) in navListingLinks"
      :key="index"
      :href="link.routeName ? route(link.routeName, listing.id) : '#'"
      class="pb-3 border-b hover:border-teal-500 -mb-[1px]"
      :class="checkIsActive(link.routeName) ? 'border-teal-500' : 'border-transparent'"
    >
      <div>
        <span class="">
          {{ link.label }}
        </span>
      </div>
    </Link> -->
  </nav>

  <XTabGroup class="hidden md:block" v-model="activeTab">
    <XTab
      v-for="link in navListingLinks"
      :key="link.label"
      :value="link.label"
      :label="link.label"
      :icon="link.inactiveIcon"
      @click="visitRoute(link)"
    >
    </XTab>
  </XTabGroup>

  <nav
    class="fixed border flex text-nowrap bottom-5 w-full bg-white/80 backdrop-blur-md max-w-[345px] inset-x-0 mx-auto md:hidden shadow-xl shadow-black/20 rounded-xl z-30 overflow-hidden"
  >
    <button
      :class="checkIsActive(link.routeName) ? ' text-teal-500 ' : 'text-slate-500 border-t-transparent'"
      class="text-xs font-medium py-3 flex-1 flex flex-col gap-1 items-center justify-center"
      v-for="link in navListingLinks"
      :key="link.label"
      @click="visitRoute(link)"
    >
      <XIcon size="lg" :icon="checkIsActive(link.routeName) ? link.activeIcon : link.inactiveIcon" />
      <p class="text-nowrap">
        {{ link.label }}
      </p>
    </button>
  </nav>
</template>

<script setup>
import { XIcon, XTab, XTabGroup } from "@indielayer/ui";
import { useListingDetailStore } from "@/State/ListingDetailStore";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { onMounted } from "vue";
import { computed } from "vue";
import { watch } from "vue";
import { onBeforeMount } from "vue";

const props = defineProps({
  listing: Object,
});

const listingDetailStore = useListingDetailStore();

const navListingLinks = [
  // { icon: "fluent:window-apps-16-regular", label: "Overview", routeName: "" },
  { inactiveIcon: "home2", activeIcon: "home_active", label: "Overview", routeName: "listing-detail.overview" },
  { inactiveIcon: "preparation", activeIcon: "preparation_active", label: "Preparation", routeName: "listing-detail.preparation" },
  { inactiveIcon: "cover_letter", activeIcon: "cover_letter_active", label: "Cover Letter", routeName: "listing-detail.coverLetter" },
  { inactiveIcon: "resume", activeIcon: "resume_active", label: "Resume", routeName: "listing-detail.resume" },
];

const activeTab = ref(listingDetailStore.state.activeTab);

const visitRoute = (link) => {
  if (link.routeName) {
    listingDetailStore.actions.setActiveTab(link.label);
    setTimeout(() => {
      router.visit(route(link.routeName, props.listing.id), {
        preserveScroll: true,
      });
    }, 75);
  }
};

onBeforeMount(() => {
  navListingLinks.map((link) => {
    if (route().current() == link.routeName) {
      listingDetailStore.actions.setActiveTab(link.label);

      activeTab.value = listingDetailStore.state.activeTab;
    }
  });
});

const checkIsActive = (routeName) => {
  return route().current() == routeName;
};
</script>
