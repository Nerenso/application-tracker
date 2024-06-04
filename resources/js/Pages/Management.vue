<template>
  <main class="flex flex-col min-h-screen w-full bg-slate-50 justify-center items-center">
    <ContentBox class="bg-white p-6 w-full max-w-screen-sm">
      <div class="space-y-6">
        <h2>Admin Management</h2>
        <form class="space-y-6" @submit.prevent="handleSubmit">
          <div class="w-full">
            <BaseLabel label="Function Name" is-required>
              <XInput placeholder="getListings" class="w-full" v-model="form.function_name" />
            </BaseLabel>
          </div>
          <XButton type="submit" color="primary">Submit</XButton>
        </form>
      </div>
    </ContentBox>
  </main>
</template>

<script setup>
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import ContentBox from "@/Components/UI/ContentBox.vue";
import { XButton, XInput } from "@indielayer/ui";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  function_name: "",
});

const handleSubmit = () => {
  form.post(route("management"), {
    onSuccess: () => form.reset(),
  });
};
</script>
