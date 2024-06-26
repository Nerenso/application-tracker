<template>
  <ListingDetailLayout :listing="listing" :tags="tags">
    <ContentBox class="w-full max-w-5xl mx-auto">
      <section class="w-full">
        <div class="">
          <header class="px-4 pt-4 md:px-6 md:pt-6">
            <h4 class="text-lg font-medium">Cover Letter Configuration</h4>
            <p class="helper-text-sm mt-1">
              This section allows you to configure the information needed to generate a cover letter. Please provide the necessary details to ensure
              your cover letter is tailored to your application.
            </p>
          </header>

          <section class="p-4 md:p-6">
            <div class="w-full border rounded-lg">
              <div class="border-b-[1px]">
                <div
                  class="flex justify-between items-center px-3 pt-3 cursor-pointer"
                  @click="showMotivation = !showMotivation"
                  :class="{ 'pb-3': !showMotivation }"
                >
                  <h4 class="text-base font-medium">Motivation</h4>
                  <Icon icon="fluent:chevron-down-16-regular" :class="showMotivation ? 'rotate-180' : ''" class="transition-all duration-150" />
                </div>
                <div :class="showMotivation ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="showMotivation = !showMotivation" class="px-3 border-b pb-3 cursor-pointer">
                      <p class="helper-text-sm py-1">
                        Write down anything that you found interesting about the listing, about why you like the company, what stands out to you about
                        them. Is it their team, the location, the clients they work with.
                      </p>
                    </div>
                    <div>
                      <!-- <XTextarea
                    :adjust-to-text="false"
                    class="w-full py-4 px-3"
                    rows="5"
                    placeholder="The job requirements fit very well with my skills and previous work experience. I enjoy working with a small team on challenging projects. I'm intrigued by the company culture you have created and I think I will be right at home with you all."
                  /> -->

                      <textarea
                        class="w-full p-3 resize-none focus:outline-teal-500"
                        name=""
                        id=""
                        cols="30"
                        rows="10"
                        placeholder="The job requirements fit very well with my skills and previous work experience. I enjoy working with a small team on challenging projects. I'm intrigued by the company culture you have created and I think I will be right at home with you all."
                      ></textarea>
                    </div>
                  </section>
                </div>
              </div>

              <div class="border-b-[1px]">
                <div
                  class="flex justify-between items-center px-3 pt-3 cursor-pointer"
                  @click="showWorkExperience = !showWorkExperience"
                  :class="{ 'pb-3': !showWorkExperience }"
                >
                  <h4 class="text-base font-medium">Work-Experience</h4>
                  <Icon icon="fluent:chevron-down-16-regular" :class="showWorkExperience ? 'rotate-180' : ''" class="transition-all duration-150" />
                </div>
                <div :class="showWorkExperience ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="showWorkExperience = !showWorkExperience" class="px-3 pt-1 pb-3 border-b cursor-pointer">
                      <p class="helper-text-sm py-1">Select the up to three most revelant work experiences.</p>
                    </div>
                    <div>
                      <SelectableItem
                        class="px-6 py-4 md:px-6 md:py-6 flex flex-col gap-4"
                        v-for="workExperience in workExperiences"
                        :key="workExperience.id"
                      >
                        <div class="space-y-1">
                          <h4 class="text-base font-medium pr-8">{{ workExperience.job_title }}</h4>

                          <div>
                            <h5 class="text-sm font-normal">{{ workExperience.company_name }}</h5>
                            <p class="helper-text-sm">{{ workExperience.employment_period }}</p>
                          </div>
                        </div>
                        <!-- <div class="whitespace-pre-wrap" v-html="workExperience.job_description"></div> -->
                      </SelectableItem>
                    </div>
                  </section>
                </div>
              </div>

              <div class="border-b">
                <div
                  @click="showEducation = !showEducation"
                  class="pt-3 px-3 cursor-pointer flex items-center justify-between"
                  :class="{ 'pb-3': !showEducation }"
                >
                  <h4 class="text-base font-medium">Education</h4>
                  <Icon icon="fluent:chevron-down-16-regular" :class="showEducation ? 'rotate-180' : ''" class="transition-all duration-150" />
                </div>
                <div :class="showEducation ? 'extended' : 'shrunk'">
                  <section class="overflow-hidden">
                    <div @click="showEducation = !showEducation" class="cursor-pointer helper-text-sm pt-1 px-3 pb-3 border-b">
                      Select up to three most relevant education.
                    </div>
                    <article class="h-48"></article>
                  </section>
                </div>
              </div>
              <div class="px-4 py-3">Skills</div>
            </div>
          </section>

          <section class="px-4 pb-4 md:px-6 md:pb-6">
            <XButton color="primary">Generate Cover Letter</XButton>
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
import BaseLabel from "@/Components/UI/BaseLabel.vue";
const props = defineProps({
  listing: Object,
  tags: Array,
  workExperiences: Array,
  education: Array,
});

const showWorkExperience = ref(false);
const showMotivation = ref(false);
const showEducation = ref(false);
const showSkills = ref(false);
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
