<template>
  <DashboardLayout title="Listing Details">
    <section class="detail-page w-full px-2 pt-6">
      <div class="max-w-5xl mx-auto w-full bg-white p-6 border rounded-lg">
        {{ listing.page_title }}

        <div v-if="props.listing.generated_description" class="whitespace-pre-line" v-html="formattedDescription"></div>
        <div v-else class="mx-auto max-w-2xl flex flex-col items-center justify-center p-6">
          <dotlottie-player src="/lottie/AI2.lottie" :autoplay.attr="true" :loop.attr="true" />
          <div class="text-center max-w-xs md:text-lg">
            <span class="block text-lg md:text-xl font-medium"> Working on it! </span>
            Check back in a few minutes.
          </div>
        </div>
      </div>
    </section>
  </DashboardLayout>
</template>

<script setup>
import "@dotlottie/player-component";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { ref } from "vue";

const props = defineProps({
  listing: Object,
});

const formattedDescription = ref("");

const getFormattedDescription = (text) => {
  const splittedText = text.split("\n");

  let prevElement = null;

  // check if prev element starts with "-", if not and the current element does, insert ul tag
  const formatted = splittedText.map((element) => {
    let stringToAdd = null;

    if (!prevElement) prevElement = element;

    if (element.slice(0, 1) == "-") {
      if (prevElement.slice(0, 3) == "<ul" || prevElement.slice(0, 4) == "<li>") {
        stringToAdd = `<li>${element.slice(2)}</li>`;
        prevElement = stringToAdd;
        return stringToAdd;
      } else {
        stringToAdd = `<ul class='list-disc ml-4 mb-4 space-y-1'><li>${element.slice(1)}</li>`;
        prevElement = stringToAdd;
        return stringToAdd;
      }
    }

    if (prevElement.slice(-5) == "</li>" && element.slice(0, 1) != "-") {
      stringToAdd = `</ul>${element}`;
      prevElement = stringToAdd;
      return stringToAdd;
    }

    if (element.slice(-1) == ":") {
      prevElement = element;
      return `<h3>${element.slice(0, -1)}</h3>`;
    } else if (element == "") {
      prevElement = element;
      return "";
    } else {
      prevElement = element;
      return element;
    }
  });

  return formatted.join("");
};

if (props.listing.generated_description) {
  formattedDescription.value = getFormattedDescription(props.listing.generated_description);
}

// const testHTML = genTest.join("");
// console.log(props.listing.page_title);
</script>
