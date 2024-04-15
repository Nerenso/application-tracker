<template>
  <DashboardLayout title="Contact Details">
    <Head title="Contact Details" />
    <div class="w-full min-h-screen p-2 md:p-6">
      <section class="max-w-5xl w-full mx-auto">
        <ContentBox class="p-4 my-4 sm:p-8">
          <header class="">
            <h4 class="text-lg font-medium">Contact Information</h4>
            <p class="helper-text-sm mt-1 max-w-2xl">This information will be included at the top of every resume you generate.</p>
          </header>

          <form class="mt-6 space-y-6 max-w-xl" @submit.prevent="submitForm">
            <div class="flex flex-col sm:flex-row w-full gap-4">
              <BaseLabel label="First Name" class="w-full" is-required>
                <XInput class="w-full" type="text" v-model="contactDetailForm.first_name" placeholder="John" />
                <p class="form-error">{{ contactDetailForm.errors.first_name }}</p>
              </BaseLabel>

              <BaseLabel label="Last Name" is-required class="w-full">
                <XInput class="w-full" type="text" v-model="contactDetailForm.last_name" placeholder="Doe" />
                <p class="form-error">{{ contactDetailForm.errors.last_name }}</p>
              </BaseLabel>
            </div>
            <div class="flex flex-col sm:flex-row w-full gap-4">
              <BaseLabel label="Email" class="w-full sm:w-3/5" is-required>
                <XInput class="w-full" type="email" v-model="contactDetailForm.email" placeholder="john@doe.com" />
                <p class="form-error">{{ contactDetailForm.errors.email }}</p>
              </BaseLabel>

              <BaseLabel label="Phone" class="w-full sm:w-2/5">
                <XInput class="w-full" type="phone" v-model="contactDetailForm.phone" placeholder="0612345678" />
                <p class="form-error">{{ contactDetailForm.errors.phone }}</p>
              </BaseLabel>
            </div>

            <div class="flex flex-col sm:flex-row w-full gap-4">
              <BaseLabel label="City" class="w-full" is-required>
                <XInput class="w-full" type="text" v-model="contactDetailForm.city" placeholder="Amsterdam" />
                <p class="form-error">{{ contactDetailForm.errors.city }}</p>
              </BaseLabel>

              <BaseLabel label="State" class="w-full">
                <XInput class="w-full" type="text" v-model="contactDetailForm.state" placeholder="Noord-Holland" />
                <p class="form-error">{{ contactDetailForm.errors.state }}</p>
              </BaseLabel>
            </div>

            <div class="flex w-full gap-4">
              <BaseLabel label="Portfolio" class="w-full">
                <XInput class="w-full" type="text" v-model="contactDetailForm.portfolio_link" placeholder="https://google.com" />
                <p class="form-error">{{ contactDetailForm.errors.portfolio_link }}</p>
              </BaseLabel>
            </div>

            <button>
              <XButton :loading="loading" color="secondary">Save</XButton>
            </button>
          </form>
        </ContentBox>
      </section>
    </div>
  </DashboardLayout>
</template>

<script setup>
import BaseLabel from "@/Components/UI/BaseLabel.vue";
import ContentBox from "@/Components/UI/ContentBox.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { XButton, XInput } from "@indielayer/ui";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { onMounted } from "vue";

const props = defineProps({
  contactDetail: Object,
});

const formSubmitOptions = {
  onStart: () => {
    setLoading();
  },
  onSuccess: () => {
    setInputValues();
    setLoading();
  },
  onError: () => {
    setLoading();
  },
};

const loading = ref(false);

const setLoading = () => {
  loading.value = !loading.value;
};

const contactDetailForm = useForm({
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  city: "",
  state: "",
  portfolio_link: "",
});

const setInputValues = () => {
  contactDetailForm.first_name = props.contactDetail.first_name;
  contactDetailForm.last_name = props.contactDetail.last_name;
  contactDetailForm.email = props.contactDetail.email;
  contactDetailForm.phone = props.contactDetail.phone;
  contactDetailForm.city = props.contactDetail.city;
  contactDetailForm.state = props.contactDetail.state;
  contactDetailForm.portfolio_link = props.contactDetail.portfolio_link;
};

onMounted(() => {
  if (props.contactDetail) {
    setInputValues();
  }
});

const submitForm = () => {
  contactDetailForm.clearErrors();

  if (props.contactDetail) {
    contactDetailForm.patch(route("contact-details.update", props.contactDetail.id), formSubmitOptions);
  } else {
    contactDetailForm.post(route("contact-details.store"), formSubmitOptions);
  }
};
</script>
