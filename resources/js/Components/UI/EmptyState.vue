<template>
  <div class="flex flex-col max-w-xl w-full mx-auto bg-white p-6 border border-dashed rounded-lg my-4">
    <img src="/images/EmptyState.png" class="w-[400px] mx-auto" />
    <div class="max-w-sm mx-auto">
      <slot></slot>
    </div>
  </div>
</template>

<script setup></script>
