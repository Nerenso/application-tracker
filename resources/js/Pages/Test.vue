<template>
  <div>
    <form>
      <XInput label="Job Listing ID" type="number" v-model="testForm.job_listing_id" />
      <x-select v-model="testForm.selectedMultiple" label="Options array" placeholder="Let's go baby" :options="options" multiple class="w-64" />

      <div v-for="option in options" :key="option.value">
        <p @click="addToSelected(option.value)">{{ option.title }}</p>
      </div>
      <XButton @click="submitForm">Send</XButton>
    </form>
  </div>
</template>

<script setup>
import { XSelect, XButton, XInput } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  tags: Array,
});

const options = props.tags.map((tag) => {
  const option = {
    value: tag.id,
    label: tag.title,
    title: tag.title,
  };

  return option;
});

function titleCase(string) {
  return string[0].toUpperCase() + string.slice(1).toLowerCase();
}

const testForm = useForm({
  job_listing_id: null,
  selectedMultiple: [],
});

const addToSelected = (item) => {
  // findItem = testForm.selectedMultiple.find((currentItem) => {
  //   return currentItem == item;
  // });

  const index = testForm.selectedMultiple.indexOf(item);

  console.log(index);
  if (index == -1) {
    testForm.selectedMultiple.push(item);
  } else if (index >= 0) {
    const newArray = [...testForm.selectedMultiple].filter((element) => element !== item);
    testForm.selectedMultiple = newArray;
  }

  console.log(testForm.selectedMultiple);
};

// const options = [
//   { value: "apple", label: "Apple" },
//   { value: "samsung", label: "Samsung" },
//   { value: "lenovo", label: "Lenovo" },
//   { value: "hp", label: "HP" },
//   { value: "dell", label: "Dell" },
//   { value: "msi", label: "MSI" },
//   { value: "acer", label: "Acer" },
// ];

const submitForm = () => {
  // console.log(testForm.selectedMultiple);
  testForm.post("/test");
};
</script>
