<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Account Information</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your account's profile information and email address.</p>
    </header>

    <form @submit.prevent="form.patch(route('account.update'))" class="mt-6 space-y-6">
      <div>
        <BaseLabel is-required label="Name">
          <XInput v-model="form.name" class="w-full" />
          <p class="form-error">{{ form.errors.name }}</p>
        </BaseLabel>
      </div>

      <div>
        <BaseLabel is-required label="Email">
          <XInput v-model="form.email" class="w-full" />
          <p class="form-error">{{ form.errors.email }}</p>
        </BaseLabel>
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
          Your email address is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
          >
            Click here to re-send the verification email.
          </Link>
        </p>

        <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
          A new verification link has been sent to your email address.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <XButton type="submit" color="secondary">Save</XButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
        </Transition>
      </div>
    </form>
  </section>
</template>

<script setup>
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import { XInput, XButton } from "@indielayer/ui";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
});
</script>
