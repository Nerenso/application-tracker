<template>
  <div class="flex min-h-screen w-full flex-col">
    <NavBar />
    <div class="pt- flex-1">
      <slot></slot>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import Footer from "@/Components/Marketing/Elements/Footer.vue";
import NavBar from "@/Components/Marketing/Elements/NavBar.vue";
</script>
