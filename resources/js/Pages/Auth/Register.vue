<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <BaseLabel label="Name" is-required>
          <XInput required autofocus v-model="form.name" class="w-full" placeholder="John" type="text" id="name" autocomplete="name" />
          <p class="form-error">{{ form.errors.name }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Email" is-required>
          <XInput v-model="form.email" class="w-full" placeholder="john@domain.com" type="email" id="email" autocomplete="email" />
          <p class="form-error">{{ form.errors.email }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password" is-required>
          <XInput required autofocus v-model="form.password" class="w-full" placeholder="secret" type="password" show-password-toggle />
          <p class="form-error">{{ form.errors.password }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password Confirmation" is-required>
          <XInput required autofocus v-model="form.password_confirmation" class="w-full" placeholder="secret" type="password" show-password-toggle />
          <p class="form-error">{{ form.errors.password }}</p>
        </BaseLabel>
      </div>

      <div class="flex items-center justify-end mt-8">
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
          Already registered?
        </Link>

        <XButton class="ms-4" color="primary" type="submit" :loading="form.processing" :disabled="form.processing">Register</XButton>
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import { XInput, XButton } from "@indielayer/ui";
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
