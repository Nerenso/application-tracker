<template>
  <div class="mx-auto max-w-2xl flex flex-col items-center justify-center p-6 mb-8">
    <dotlottie-player src="/lottie/AI2.lottie" :autoplay.attr="true" :loop.attr="true" />
    <div class="text-center max-w-xs md:text-lg">
      <span class="block text-lg md:text-xl font-medium">
        <slot name="title"> Working on it! </slot>
      </span>
      <slot name="subtitle"> Check back in a few minutes. </slot>
    </div>
  </div>
</template>

<script setup></script>
