<template>
  <GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <XInput
          label="Email"
          v-model="form.email"
          class="w-full"
          :required="true"
          placeholder="john@domain.com"
          type="email"
          id="email"
        />
        <p class="form-error">{{ form.errors.email }}</p>
      </div>

      <div class="mt-4">
        <XInput
          label="Password"
          v-model="form.password"
          class="w-full"
          :required="true"
          type="password"
          show-password-toggle
          placeholder="Password"
        />
        <p class="form-error">{{ form.errors.password }}</p>
      </div>

      <div class="mt-4 block">
        <XCheckbox label="Remember me" size="sm" v-model="form.remember" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
        >
          Forgot your password?
        </Link>
        <XButton
          type="submit"
          class="ms-4"
          color="primary"
          :loading="form.processing"
          :disabled="form.processing"
          >Log in</XButton
        >
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import { XInput, XCheckbox, XButton } from "@indielayer/ui";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>
