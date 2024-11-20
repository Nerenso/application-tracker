<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <BaseLabel label="Name" is-required>
          <XInput
            required
            autofocus
            v-model="form.name"
            class="w-full"
            placeholder="John"
            type="text"
            id="name"
            autocomplete="name"
          />
          <p class="form-error">{{ form.errors.name }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Email" is-required>
          <XInput
            v-model="form.email"
            class="w-full"
            placeholder="john@domain.com"
            type="email"
            id="email"
            autocomplete="email"
          />
          <p class="form-error">{{ form.errors.email }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password" is-required>
          <XInput
            required
            autofocus
            v-model="form.password"
            class="w-full"
            placeholder="Password"
            type="password"
            show-password-toggle
          />
          <p class="form-error">{{ form.errors.password }}</p>
        </BaseLabel>
      </div>

      <div class="mt-4">
        <BaseLabel label="Password Confirmation" is-required>
          <XInput
            required
            autofocus
            v-model="form.password_confirmation"
            class="w-full"
            placeholder="Password Confirmation"
            type="password"
            show-password-toggle
          />
          <p class="form-error">{{ form.errors.password }}</p>
        </BaseLabel>
      </div>

      <div class="mt-8 flex items-center justify-end">
        <Link
          :href="route('login')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
        >
          Already registered?
        </Link>

        <XButton
          class="ms-4"
          color="primary"
          type="submit"
          :loading="form.processing"
          :disabled="form.processing"
          >Register</XButton
        >
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
