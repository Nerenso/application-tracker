<template>
  <section class="flex-1 w-full">
    <div class="mx-auto max-w-5xl w-full p-4">
      <section class="flex flex-col w-full rounded-md border overflow-hidden bg-white">
        <div class="col-span-1 p-6 flex flex-col items-center justify-center overflow-hidden border-b">
          <div class="w-full">
            <h2 class="text-left text-xl font-semibold">{{ listingInfo.pageTitle }}</h2>
          </div>
          <div class="w-full grid grid-cols-1 md:grid-cols-2">
            <section class="bg-blue-300">CONTENT</section>
            <img
              :src="
                listingInfo.img
                  ? listingInfo.img
                  : 'https://lh3.googleusercontent.com/3bXLbllNTRoiTCBdkybd1YzqVWWDRrRwJNkVRZ3mcf7rlydWfR13qJlCSxJRO8kPe304nw1jQ_B0niDo56gPgoGx6x_ZOjtVOK6UGIr3kshpmTq46pvFObfJ2K0wzoqk36MWWSnh0y9PzgE7PVSRz6Y'
              "
              alt=""
              class="object-contain"
            />
          </div>
        </div>
        <div class="w-full p-6 flex flex-col justify-between gap-4">
          <!-- <p>{{ desc }}</p> -->
          <div class="flex w-full gap-4">
            <a :href="listingInfo.companyUrl" target="_blank">{{ listingInfo.companyName }}</a>
            <a :href="listingInfo.url" target="_blank">View Job Listing</a>
          </div>
        </div>
      </section>
      <!-- <pre>{{ info }}</pre> -->
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  listingInfo: Object,
});
</script>

<style lang="scss" scoped></style>
