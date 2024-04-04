<template>
  <GuestLayout>
    <Head title="Forgot Password" />

    <div class="helper-text-sm">
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose
      a new one.
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <div class="mt-4">
          <BaseLabel label="Email" is-required>
            <XInput required autofocus class="w-full" placeholder="john@apple.com" type="email" v-model="form.email" />
            <p class="form-error">{{ form.errors.email }}</p>
          </BaseLabel>
        </div>
      </div>

      <div class="flex items-center justify-end mt-4">
        <XButton color="primary" :loading="form.processing" @click="submit">Email Reset Password Link</XButton>
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Breeze/InputError.vue";
import InputLabel from "@/Components/Breeze/InputLabel.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import TextInput from "@/Components/Breeze/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import { XButton, XInput } from "@indielayer/ui";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>
