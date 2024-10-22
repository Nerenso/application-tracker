<template>
  <MarketingPagesLayout class="landing-page">
    <Head title="Home" />

    <section class="relative mx-auto w-full px-0 pt-28 md:pt-44">
      <div
        class="z-50 mx-auto w-full px-4 text-left md:text-center lg:px-12 xl:max-w-6xl"
      >
        <h1
          class="mb-4 font-extrabold leading-none tracking-normal text-gray-900 md:tracking-tight"
        >
          Landing your
          <span
            class="block w-full bg-gradient-to-br from-emerald-300 to-sky-500 bg-clip-text text-transparent sm:inline"
            >dream job</span
          >
          without the mental exhaustion.
        </h1>
        <p
          class="mb-6 px-0 text-lg text-gray-500 md:mb-8 md:text-xl md:leading-8 lg:px-28"
        >
          An all in one platform to manage your job search seamlessly with
          application tracking and custom tailored personalized documents to
          match the job you're looking for.
        </p>

        <Link
          :href="route('register')"
          class="z-20 inline-block rounded-lg bg-slate-900 px-4 py-2.5 text-lg font-semibold text-white transition-all duration-200 hover:bg-slate-700"
        >
          Get Started
        </Link>
      </div>
      <div class="mt-12 flex w-full overflow-auto px-4 md:mt-24">
        <img
          src="/images/Jobdeck-Dashboard.png"
          alt=""
          class="mx-auto mb-12 w-full min-w-[800px] max-w-6xl flex-shrink-0 rounded-2xl border shadow-[0_30px_40px_-25px_rgba(0,0,0,0.25)] md:mb-20"
        />
      </div>
    </section>

    <section class="bg-transparent p-4 md:hidden">
      <article
        class="relative flex h-fit w-full items-center gap-4 rounded-2xl bg-gradient-to-bl from-slate-800 via-teal-950 to-slate-800 p-4 shadow-xl"
      >
        <div class="relative h-28 w-20 shrink-0 overflow-hidden rounded-xl">
          <img
            src="/images/testimonial_pic.jpeg"
            alt=""
            class="absolute w-full"
          />
        </div>

        <div class="flex flex-col items-center justify-center text-white">
          <h5 class="mb-1 w-full text-left font-semibold text-white">
            Arno Dijkstra
          </h5>
          <p class="text-sm text-slate-300">
            I struggled with getting responses until Jobdeck helped me land my
            dream job as a Marketing Manager.
          </p>
        </div>
      </article>
    </section>

    <div class="mt-4 w-full p-4 md:mb-12">
      <section
        class="mx-auto w-full max-w-6xl rounded-2xl border bg-slate-100/70"
      >
        <div
          class="flex w-full flex-wrap justify-between p-4 lg:px-12 lg:pt-12"
        >
          <h2 class="mb-8 max-w-xs pr-5 leading-9 md:mb-20">
            Everything you need to land your dream job.
          </h2>

          <article
            class="relative hidden h-fit max-w-sm items-center gap-4 rounded-2xl bg-gradient-to-bl from-slate-800 via-teal-950 to-slate-800 p-6 shadow-xl md:flex"
          >
            <div
              class="relative h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-300"
            >
              <img
                src="/images/testimonial_pic.jpeg"
                alt=""
                class="absolute w-full"
              />
            </div>

            <div class="flex flex-col items-center justify-center text-white">
              <h5 class="mb-1 w-full text-left font-semibold text-white">
                Arno Dijkstra
              </h5>
              <p class="text-sm text-slate-300">
                I struggled with getting responses until Jobdeck helped me land
                my dream job as a Marketing Manager.
              </p>
            </div>
          </article>
        </div>

        <div
          class="mb-10 grid w-full grid-cols-1 gap-12 p-4 md:grid-cols-3 md:gap-8 lg:px-12"
        >
          <section class="col-span-1">
            <div
              class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-lg md:h-20 md:w-20 md:rounded-2xl"
            >
              <Icon
                icon="solar:graph-new-line-duotone"
                class="h-8 w-8 text-teal-500"
              />
            </div>
            <div class="mt-4 space-y-2 leading-relaxed md:mt-6">
              <h4>Easy Application Tracking</h4>
              <p>
                Keep all your job applications organized in one place, making it
                easy to monitor your progress and deadlines.
              </p>
            </div>
          </section>

          <section class="col-span-1">
            <div
              class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-lg md:h-20 md:w-20 md:rounded-2xl"
            >
              <Icon
                icon="solar:watch-round-line-duotone"
                class="h-10 w-10 text-teal-500"
              />
            </div>
            <div class="mt-4 space-y-2 leading-relaxed md:mt-6">
              <h4>Time and Energy Savings</h4>
              <p>
                Reduce the mental load of job applications, allowing you to
                focus on preparing for interviews and networking instead.
              </p>
            </div>
          </section>

          <section class="col-span-1">
            <div
              class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-lg md:h-20 md:w-20 md:rounded-2xl"
            >
              <Icon
                icon="solar:minimize-square-3-line-duotone"
                class="h-8 w-8 text-teal-500"
              />
            </div>
            <div class="mt-4 space-y-2 leading-relaxed md:mt-6">
              <h4>Streamlined Job Insights</h4>
              <p>
                Add links to job listings, and let us transform them into
                concise summaries that capture the vital details without the
                fluff.
              </p>
            </div>
          </section>
        </div>

        <div
          class="my-12 hidden w-full grid-cols-1 gap-12 p-4 md:grid md:grid-cols-2 lg:px-12"
        >
          <CoverLetterCard />
          <ResumesCard />
        </div>
      </section>
    </div>

    <div class="my-0 w-full p-4 md:hidden">
      <CoverLetterCard class="border" />
      <ResumesCard class="mt-8 border" />
    </div>
    <div class="mb-24 mt-12 px-4">
      <GetStartedCTA />
    </div>
  </MarketingPagesLayout>
</template>

<script setup>
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Icon } from "@iconify/vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import NavBar from "@/Components/Marketing/Elements/NavBar.vue";
import GetStartedCTA from "@/Components/Marketing/Elements/GetStartedCTA.vue";
import Footer from "@/Components/Marketing/Elements/Footer.vue";
import CoverLetterCard from "@/Components/Marketing/Elements/CoverLetterCard.vue";
import ResumesCard from "@/Components/Marketing/Elements/ResumesCard.vue";
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
</script>
