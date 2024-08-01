<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ContentBox class="w-full max-w-5xl mx-auto">
      <section class="p-3 md:p-6">
        <header class="p-1">
          <h4>Cover Letter</h4>
        </header>
        <main class="">
          <EmptyState v-if="!generatedCoverLetter && !isGenerating">
            <div class="flex flex-col gap-4 mb-4">
              <p class="empty-state-text">You haven't generated your cover letter yet. Scroll down to configure your settings.</p>
            </div>
          </EmptyState>
          <LoadingGraphic v-if="isGenerating">
            <template #title> Generating Your Cover Letter! </template>
            <template #subtitle> It will be ready shortly. </template>
          </LoadingGraphic>
          <div v-if="generatedCoverLetter && !isGenerating" class="pt-6">
            <textarea
              ref="coverLetterTextArea"
              name="text"
              v-model="coverLetterContent"
              @input="resizeTextArea"
              class="w-full rounded-lg border outline-none p-2.5 md:p-6 focus:border-transparent focus:outline-teal-500 hover:border-teal-500"
              style="resize: none"
              @blur="checkContent"
            ></textarea>
          </div>
        </main>
      </section>

      <section class="w-full">
        <div class="">
          <header class="px-4 pt-4 mb-2 md:px-6 md:pt-6 md:mb-0">
            <h4 class="text-lg font-medium">Cover Letter Configuration</h4>
            <p class="helper-text-sm mt-1">Fill out the details below to generate your cover letter.</p>
          </header>

          <section class="p-3 md:p-6">
            <div class="w-full border rounded-lg">
              <div class="border-b-[1px]">
                <div
                  class="flex justify-between items-center px-3 pt-3 cursor-pointer"
                  @click="setActiveTab('motivation')"
                  :class="{ 'pb-3': !checkActiveTab('motivation') }"
                >
                  <h4 class="text-base font-medium">Motivation<span class="text-red-500">*</span></h4>
                  <Icon
                    icon="fluent:chevron-down-16-regular"
                    :class="checkActiveTab('motivation') ? 'rotate-180' : ''"
                    class="transition-all duration-150"
                  />
                </div>
                <div :class="checkActiveTab('motivation') ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="setActiveTab('motivation')" class="px-3 border-b pb-3 cursor-pointer">
                      <p class="helper-text-sm py-1 leading-normal">
                        Write down anything that you found interesting about the listing, about why you like the company, what stands out to you about
                        them. Is it their team, the location, the clients they work with.
                      </p>
                    </div>
                    <div>
                      <textarea
                        class="w-full p-3 resize-none focus:outline-teal-500"
                        name=""
                        id=""
                        cols="30"
                        rows="10"
                        v-model="motivation"
                        placeholder="The job requirements fit very well with my skills and previous work experience. I enjoy working with a small team on challenging projects. I'm intrigued by the company culture you have created and I think I will be right at home with you all."
                      ></textarea>
                    </div>
                  </section>
                </div>
              </div>

              <div class="border-b-[1px]">
                <div
                  class="flex justify-between items-center px-3 pt-3 cursor-pointer"
                  @click="setActiveTab('workExperience')"
                  :class="{ 'pb-3': !checkActiveTab('workExperience') }"
                >
                  <div class="w-full flex items-center gap-2">
                    <h4 class="text-base font-medium">Work-Experience<span class="text-red-500">*</span></h4>
                    <span class="helper-text-sm">({{ selectedWorkExperiences.length }} selected)</span>
                  </div>
                  <Icon
                    icon="fluent:chevron-down-16-regular"
                    :class="checkActiveTab('workExperience') ? 'rotate-180' : ''"
                    class="transition-all duration-150"
                  />
                </div>
                <div :class="checkActiveTab('workExperience') ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="setActiveTab('workExperience')" class="px-3 pt-1 pb-3 border-b cursor-pointer">
                      <p class="helper-text-sm py-1">Select the up to three most revelant work experiences.</p>
                    </div>
                    <div>
                      <SelectableItem
                        class="px-6 py-4 md:px-6 md:py-6 flex flex-col gap-4"
                        v-for="workExperience in workExperiences"
                        :key="workExperience.id"
                        :selected="checkIfSelected(workExperience, selectedWorkExperiences)"
                        @click="handleItemSelection(workExperience, selectedWorkExperiences)"
                      >
                        <div class="space-y-1">
                          <h4 class="text-base font-medium pr-8">{{ workExperience.job_title }}</h4>

                          <div>
                            <h5 class="text-sm font-normal">{{ workExperience.company_name }}</h5>
                            <p class="helper-text-sm">{{ workExperience.employment_period }}</p>
                          </div>
                        </div>
                      </SelectableItem>
                    </div>
                  </section>
                </div>
              </div>

              <div class="border-b">
                <div
                  @click="setActiveTab('education')"
                  class="pt-3 px-3 cursor-pointer flex items-center justify-between"
                  :class="{ 'pb-3': !checkActiveTab('education') }"
                >
                  <div class="w-full flex items-center gap-2">
                    <h4 class="text-base font-medium">Education<span class="text-red-500">*</span></h4>
                    <span class="helper-text-sm">({{ selectedEducation.length }} selected)</span>
                  </div>
                  <Icon
                    icon="fluent:chevron-down-16-regular"
                    :class="checkActiveTab('education') ? 'rotate-180' : ''"
                    class="transition-all duration-150"
                  />
                </div>
                <div :class="checkActiveTab('education') ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="setActiveTab('education')" class="cursor-pointer helper-text-sm pt-1 px-3 pb-3 border-b">
                      Select up to three most relevant education.
                    </div>
                    <SelectableItem
                      class="px-6 py-4 md:px-6 md:py-6 flex flex-col gap-4"
                      v-for="edu in education"
                      :key="edu.id"
                      :selected="checkIfSelected(edu, selectedEducation)"
                      @click="handleItemSelection(edu, selectedEducation)"
                    >
                      <div class="space-y-1">
                        <h4 class="text-base font-medium pr-8">{{ edu.degree_name }}</h4>

                        <div>
                          <p class="helper-text-sm">{{ edu.institution_name }}, {{ edu.location }}, {{ edu.years_attended }}</p>
                        </div>
                      </div>
                    </SelectableItem>
                  </section>
                </div>
              </div>

              <div class="">
                <div
                  class="flex justify-between items-center px-3 pt-3 cursor-pointer"
                  @click="setActiveTab('skills')"
                  :class="{ 'pb-3': !checkActiveTab('skills') }"
                >
                  <div class="w-full flex items-center gap-2">
                    <h4 class="text-base font-medium">Skills<span class="text-red-500">*</span></h4>
                    <span class="helper-text-sm">({{ selectedSkills.length }} selected)</span>
                  </div>
                  <Icon
                    icon="fluent:chevron-down-16-regular"
                    :class="checkActiveTab('skills') ? 'rotate-180' : ''"
                    class="transition-all duration-150"
                  />
                </div>
                <div :class="checkActiveTab('skills') ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="setActiveTab('skills')" class="px-3 pt-1 pb-3 border-b cursor-pointer">
                      <p class="helper-text-sm py-1">Select the up to three most revelant work experiences.</p>
                    </div>
                    <div>
                      <SelectableItem
                        class="px-6 py-4 md:px-6 md:py-6 flex flex-col gap-4"
                        v-for="skill in skills"
                        :key="skill.id"
                        @click="handleItemSelection(skill, selectedSkills)"
                        :selected="checkIfSelected(skill, selectedSkills)"
                      >
                        <div class="space-y-1">
                          <h4 class="text-base font-medium pr-8">{{ skill.title }}</h4>

                          <div>
                            <p class="helper-text-sm">{{ skill.description }}</p>
                          </div>
                        </div>
                      </SelectableItem>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </section>

          <section class="px-4 pb-4 mt-2 md:mt-0 md:px-6 md:pb-6">
            <XButton v-if="!generatedCoverLetter" @click="createNewCoverLetter()" :disabled="!canGenerate()" color="primary"
              >Generate Cover Letter</XButton
            >
            <XButton v-else @click="regenerateCoverLetter" :disabled="!canGenerate()" color="primary">Regenerate Cover Letter</XButton>
          </section>
        </div>
      </section>
    </ContentBox>
  </ListingDetailLayout>
</template>

<script setup>
import ListingDetailLayout from "@/Layouts/ListingDetailLayout.vue";
import ContentBox from "@/Components/UI/ContentBox.vue";
import SelectableItem from "@/Components/UI/SelectableItem.vue";
import { Icon } from "@iconify/vue";
import { ref } from "vue";
import { XButton, XTextarea } from "@indielayer/ui";
import EmptyState from "@/Components/UI/EmptyState.vue";
import { router } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { watch } from "vue";
import LoadingGraphic from "@/Components/UI/LoadingGraphic.vue";

const props = defineProps({
  listing: Object,
  tags: Array,
  workExperiences: Array,
  skills: Array,
  education: Array,
  coverLetter: Object,
});

const activeConfigTab = ref("");

const motivation = ref("");
const isGenerating = ref(false);
const generatedCoverLetter = ref("");
const coverLetterContent = ref("");
const coverLetterTextArea = ref(null);
const selectedWorkExperiences = ref([]);
const selectedSkills = ref([]);
const selectedEducation = ref([]);

const resizeTextArea = (event) => {
  const textArea = event.target;
  textArea.style.height = "";
  textArea.style.height = textArea.scrollHeight + "px";
};

let echoChannel;

onMounted(() => {
  if (props.coverLetter) {
    generatedCoverLetter.value = props.coverLetter;
    coverLetterContent.value = props.coverLetter.generated_letter;
    motivation.value = props.coverLetter.motivation;
    setTimeout(() => {
      resizeTextArea({ target: coverLetterTextArea.value });
    }, 0);
  }
});

watch(generatedCoverLetter, (newVal, oldVal) => {
  if (newVal !== oldVal) {
    coverLetterContent.value = newVal.generated_letter;
    if (echoChannel) {
      echoChannel.stopListening("CoverLetterGenerationFinished");
    }
  }
});

const checkContent = () => {
  if (coverLetterContent.value !== generatedCoverLetter.value.generated_letter) {
    console.log("content changed");
    saveChangesToDB();
  }
};

const setActiveTab = (tab) => {
  activeConfigTab.value == tab ? (activeConfigTab.value = "") : (activeConfigTab.value = tab);
};

const checkActiveTab = (tab) => {
  return activeConfigTab.value == tab;
};

const handleItemSelection = (item, array) => {
  if (array.includes(item)) {
    array.splice(array.indexOf(item), 1);
  } else {
    array.push(item);
  }
};

const checkIfSelected = (item, array) => {
  return array.includes(item);
};

const startGeneration = () => {
  isGenerating.value = true;
  echoChannel = Echo.private(`job-listings.${props.listing.id}.cover-letter`);

  echoChannel.listen("CoverLetterGenerationFinished", (e) => {
    generatedCoverLetter.value = e.cover_letter;
    isGenerating.value = false;
    setTimeout(() => {
      resizeTextArea({ target: coverLetterTextArea.value });
    }, 0);
  });
};

const createNewCoverLetter = () => {
  startGeneration();
  router.post(
    route("cover-letter.store", props.listing.id),
    {
      listingId: props.listing.id,
      motivation: motivation.value,
      selectedWorkExperiences: selectedWorkExperiences.value,
      selectedSkills: selectedSkills.value,
      selectedEducation: selectedEducation.value,
    },
    {
      preserveScroll: true,
    }
  );
  resetConfigurationStates();
};

const regenerateCoverLetter = () => {
  startGeneration();
  router.patch(
    route("cover-letter.update", generatedCoverLetter.value.id),
    {
      updateType: "regenerate",
      listingId: props.listing.id,
      motivation: motivation.value,
      selectedWorkExperiences: selectedWorkExperiences.value,
      selectedSkills: selectedSkills.value,
      selectedEducation: selectedEducation.value,
    },
    {
      preserveScroll: true,
    }
  );
  resetConfigurationStates();
};

function canGenerate() {
  return motivation.value !== "" && selectedEducation.value.length > 0 && selectedWorkExperiences.value.length > 0 && selectedSkills.value.length > 0;
}

const saveChangesToDB = () => {
  router.patch(
    route("cover-letter.update", generatedCoverLetter.value.id),
    {
      updateType: "update",
      listingId: props.listing.id,
      coverLetterContent: coverLetterContent.value,
    },
    {
      preserveScroll: true,
    }
  );
};

const resetConfigurationStates = () => {
  setActiveTab("");
  selectedWorkExperiences.value = [];
  selectedSkills.value = [];
  selectedEducation.value = [];
};
</script>

<style>
.shrunk {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 200ms;
}

.extended {
  display: grid;
  transition: grid-template-rows 200ms;
  grid-template-rows: 1fr;
}
</style>
