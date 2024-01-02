<template>
  <div>
    HELLO
    {{ listing.page_title }}
  </div>
</template>

<script setup>
const props = defineProps({
  listing: Object,
});

console.log(props.listing);
</script>
