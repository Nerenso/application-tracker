<template>
  <MarketingPagesLayout class="landing-page">
    <Head title="Contact" />
    <section class="mx-auto w-full pt-24">
      <div class="mx-auto max-w-6xl">
        <section class="body-font relative text-gray-600">
          <div class="container mx-auto px-4 py-0 md:py-24">
            <div class="mb-12 flex w-full flex-col md:text-center">
              <h1
                class="mb-4 font-extrabold leading-none tracking-normal text-gray-900 md:tracking-tight"
              >
                Get in Touch
              </h1>
              <p
                class="mb-6 px-0 text-lg text-gray-500 md:mb-8 md:text-xl md:leading-8 lg:px-28"
              >
                Have a question about your job applications? Need assistance
                with tailored resumes or cover letters? Want to share your
                thoughts on a new feature? We’re all ears! You can use the form
                below, or any of the other contact options listed.
              </p>
            </div>

            <form
              class="mx-auto md:w-2/3 lg:w-1/2"
              @submit.prevent="submitContactForm"
            >
              <div class="grid w-full grid-cols-2 gap-4">
                <article class="col-span-2 w-full md:col-span-1">
                  <BaseLabel label="Name" is-required>
                    <XInput
                      class="w-full"
                      placeholder="John"
                      v-model="contactForm.name"
                    />
                    <p class="form-error">
                      {{ contactForm.errors.name }}
                    </p>
                  </BaseLabel>
                </article>
                <article class="col-span-2 w-full md:col-span-1">
                  <BaseLabel label="Email" is-required>
                    <XInput
                      class="w-full"
                      placeholder="john@email.com"
                      v-model="contactForm.email"
                      type="email"
                    />
                    <p class="form-error">
                      {{ contactForm.errors.email }}
                    </p>
                  </BaseLabel>
                </article>

                <article class="col-span-2 w-full">
                  <BaseLabel label="Message" is-required>
                    <XTextarea
                      :adjust-to-text="false"
                      class="w-full"
                      rows="5"
                      placeholder="Enter your message here..."
                      v-model="contactForm.message"
                    />
                    <p class="form-error">
                      {{ contactForm.errors.message }}
                    </p>
                  </BaseLabel>
                </article>
              </div>

              <div class="mt-8 w-full text-center">
                <button
                  type="submit"
                  class="z-20 mx-auto rounded-lg bg-slate-900 px-4 py-2.5 font-semibold text-white transition-all duration-200 hover:bg-slate-700"
                >
                  Send Message
                </button>
              </div>

              <section
                class="mt-8 flex w-full items-center justify-center gap-2 text-sm"
              >
                <hr class="w-full border-slate-300" />
                <p>OR</p>
                <hr class="w-full border-slate-300" />
              </section>

              <div
                class="mb-24 mt-4 flex items-center justify-center gap-2 md:mb-0"
              >
                <a href="mailto:nerenso@hotmail.com">
                  <Icon
                    icon="heroicons:envelope"
                    class="h-[26px] w-[26px] cursor-pointer"
                  />
                </a>
                <a
                  href="https://www.linkedin.com/in/nerenso-mahabir-52b0b91b/"
                  target="_blank"
                >
                  <Icon
                    icon="flowbite:linkedin-solid"
                    class="mb-0.5 h-8 w-8 cursor-pointer"
                  />
                </a>
              </div>
            </form>
          </div>
        </section>
      </div>
    </section>
  </MarketingPagesLayout>
</template>

<script setup>
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
import { Icon } from "@iconify/vue";
import { XInput, XTextarea } from "@indielayer/ui";
import { Head, Link, useForm } from "@inertiajs/vue3";

const contactForm = useForm({
  name: "",
  email: "",
  message: "",
});

const submitContactForm = () => {
  contactForm.post(route("marketing.contact-form"), {
    onSuccess: () => {
      contactForm.reset();
    },
  });
};
</script>
