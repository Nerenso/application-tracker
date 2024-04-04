<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import { XButton, XInput } from "@indielayer/ui";

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <form @submit.prevent="submit">
      <div class="mt-4">
        <BaseLabel label="Email" is-required>
          <XInput required autofocus class="w-full" placeholder="john@apple.com" type="email" v-model="form.email" />
          <p class="form-error">{{ form.errors.email }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password" is-required>
          <XInput required autofocus class="w-full" placeholder="secret" type="password" show-password-toggle v-model="form.password" />
          <p class="form-error">{{ form.errors.password }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password Confirmation" is-required>
          <XInput required autofocus class="w-full" placeholder="secret" type="password" show-password-toggle v-model="form.password_confirmation" />
          <p class="form-error">{{ form.errors.password_confirmation }}</p>
        </BaseLabel>
      </div>

      <div class="flex items-center justify-end mt-4">
        <XButton color="primary" :loading="form.processing" @click="submit">Reset Password</XButton>
      </div>
    </form>
  </GuestLayout>
</template>
