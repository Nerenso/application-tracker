<template>
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
    class="fixed inset-x-0 bottom-0 z-30 flex w-full overflow-hidden text-nowrap rounded-t-xl border bg-white/70 shadow-xl backdrop-blur-md md:hidden"
  >
    <div
      class="mx-auto flex w-full max-w-[432px] items-center justify-evenly pb-4"
    >
      <button
        :class="
          checkIsActive(link.routeName)
            ? 'text-teal-500'
            : 'border-t-transparent text-slate-500'
        "
        class="flex flex-1 flex-col items-center justify-center gap-1 py-3 text-[10.5px] font-medium"
        v-for="link in navListingLinks"
        :key="link.label"
        @click="visitRoute(link)"
      >
        <XIcon
          size="lg"
          :icon="
            checkIsActive(link.routeName) ? link.activeIcon : link.inactiveIcon
          "
        />
        <p class="text-nowrap">
          {{ link.label }}
        </p>
      </button>
    </div>
  </nav>
</template>

<script setup>
import { XIcon, XTab, XTabGroup } from "@indielayer/ui";
import { useListingDetailStore } from "@/State/ListingDetailStore";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { onBeforeMount } from "vue";

const props = defineProps({
  listing: Object,
});

const listingDetailStore = useListingDetailStore();

const navListingLinks = [
  {
    inactiveIcon: "home2",
    activeIcon: "home_active",
    label: "Overview",
    routeName: "listing-detail.overview",
  },
  {
    inactiveIcon: "preparation",
    activeIcon: "preparation_active",
    label: "Preparation",
    routeName: "listing-detail.preparation",
  },
  {
    inactiveIcon: "todo",
    activeIcon: "todo_active",
    label: "Todo",
    routeName: "listing-detail.todo",
  },
  {
    inactiveIcon: "documents2",
    activeIcon: "documents2_active",
    label: "Documents",
    routeName: "listing-detail.documents",
  },

  {
    inactiveIcon: "timeline",
    activeIcon: "timeline_active",
    label: "Timeline",
    routeName: "listing-detail.timeline",
  },
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
