<template>
  <Head title="Home" />
  <div class="landing-page min-h-screen w-full">
    <header
      class="relative h-[900px] w-full bg-gradient-to-b from-emerald-500 to-teal-500 md:h-[1025px] lg:h-[1150px]"
    >
      <nav class="fixed z-40 w-full px-4 py-4 sm:px-4 lg:py-8">
        <section
          class="mx-auto w-full max-w-6xl rounded-xl border bg-white px-6 py-5 shadow-xl shadow-black/15 transition-all duration-300"
        >
          <div class="flex w-full items-center justify-between">
            <Link href="/"> <AppLogo class="w-[112px]" /></Link>
            <div class="hidden md:flex md:gap-4">
              <Link :href="route('login')">Login</Link>
              <Link :href="route('register')">Register</Link>
            </div>
            <div class="md:hidden">
              <Icon
                v-if="!showMenu"
                icon="solar:hamburger-menu-linear"
                class="h-8 w-8 text-slate-600"
                @click="showMenu = !showMenu"
              />
              <Icon
                v-else
                icon="carbon:close-large"
                class="h-8 w-8 p-0.5 text-slate-600"
                @click="showMenu = !showMenu"
              />
            </div>
          </div>
          <menu
            class="w-full bg-white transition-all duration-300"
            :class="showMenu ? 'h-80' : 'h-0'"
            v-if="showMenu"
          ></menu>
        </section>
      </nav>
      <section class="mx-auto w-full max-w-6xl p-4 pt-16">
        <article class="mb-8 mt-24 md:mt-32">
          <p class="mb-6 hidden text-center text-white/80 md:block">
            Introducing Jobdeck
          </p>
          <h2 class="mb-4 text-center text-5xl text-white">
            Smart Job Hunting
          </h2>
          <p
            class="mx-auto max-w-3xl text-center text-lg font-medium text-white/90"
          >
            <!-- Exhausted, overwhelmed and frustrated? We got your back!
            Effortlessly track your job applications, get your cover letters and
            custom tailored resumes written to perfectly fit the job you're
            looking for. -->

            Overwhelmed and frustrated? We've got your back! Seamlessly manage
            your job applications and get custom-written cover letters and
            resumes designed just for the job you want.
          </p>

          <div
            class="mx-auto mt-10 flex w-full max-w-sm items-center justify-center gap-4 font-medium text-white/85"
          >
            <!-- <button class="rounded-lg bg-white/30 px-4 py-2.5 text-lg">
              Learn More
            </button> -->
            <button class="rounded-lg bg-slate-900 px-4 py-2.5 text-lg">
              Get Started
            </button>
          </div>
        </article>
      </section>

      <div class="absolute flex w-full overflow-auto px-4">
        <!-- <div class="w-full min-w-[800px] max-w-6xl h-[600px] mx-auto flex-shrink-0 bg-gradient-to-tr from-orange-500 to-rose-600"></div> -->
        <img
          src="/images/Jobdeck-Dashboard.png"
          alt=""
          class="mx-auto mb-20 w-full min-w-[800px] max-w-6xl flex-shrink-0 rounded-2xl shadow-2xl shadow-black/40"
        />
        <!-- <div class="-bottom-96 w-full mr-5">

        </div> -->
      </div>
    </header>

    <div class="mt-40 w-full p-4 sm:mt-20 md:mt-24 lg:mt-32">
      <section
        class="mx-auto w-full max-w-6xl rounded-2xl border bg-slate-100/60 p-6 md:p-12"
      >
        <h2 class="mb-20 max-w-xs leading-9">
          Everything you need to land your dream job.
        </h2>
        <div
          class="mb-10 grid w-full grid-cols-1 gap-12 md:grid-cols-3 md:gap-8"
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

        <div class="mt-28 grid w-full grid-cols-1 gap-12 md:grid-cols-2">
          <div
            class="group/card flex h-fit flex-col rounded-lg bg-white p-1 shadow-[0_30px_40px_-25px_rgba(0,0,0,0.25)] transition-all duration-300"
          >
            <section class="overflow-hidden rounded-md">
              <div
                class="relative overflow-hidden bg-slate-200 transition-all duration-300"
              >
                <div
                  class="absolute top-0 z-20 h-[22rem] w-full bg-gradient-to-t from-slate-400/10 to-transparent"
                ></div>
                <div
                  class="h-[22rem] w-full bg-gradient-to-br from-teal-50 to-emerald-50 saturate-0 transition-all duration-300 group-hover/card:h-[20rem] group-hover/card:saturate-100"
                ></div>
                <img
                  src="/images/CoverLetterConfig.png"
                  alt="Description"
                  class="absolute -bottom-3 -right-5 max-w-[72%] rounded-xl bg-blend-normal transition-all duration-300 group-hover/card:translate-y-6"
                />
              </div>
              <div
                class="z-10 bg-white p-8 transition-all duration-300 group-hover/card:pb-2"
              >
                <div class="flex w-full items-center gap-2.5">
                  <Icon
                    icon="solar:letter-opened-bold-duotone"
                    class="h-7 w-7 text-teal-400"
                  />
                  <h3>Personalized Cover Letters</h3>
                </div>
                <p class="mt-4 text-lg leading-7 text-slate-500">
                  Compelling cover letters that highlight why you're the ideal
                  candidate, by taking into account your work-experience,
                  education, motivation and skillset.
                </p>
              </div>
              <div
                class="group-hover/card: h-0 bg-white px-8 transition-all duration-300 group-hover/card:h-14"
              >
                <div
                  class="group flex w-fit cursor-pointer items-center gap-1.5 text-teal-500 opacity-0 transition-all duration-150 group-hover/card:opacity-100"
                >
                  <p
                    class="font-semibold transition-all duration-150 group-hover:text-slate-800"
                  >
                    Get Started
                  </p>
                  <p
                    class="group -ml-1 mb-[2px] text-[22px] font-semibold transition-all duration-150 group-hover:ml-0"
                  >
                    <span
                      class="opacity-0 transition-all duration-150 group-hover:text-slate-800 group-hover:opacity-100"
                      >-</span
                    >
                    <span
                      class="-ml-[6px] transition-all duration-150 group-hover:text-slate-800"
                      >›</span
                    >
                  </p>
                </div>
              </div>
            </section>
          </div>

          <div
            class="group/card flex flex-col rounded-lg bg-white p-1 shadow-[0_30px_40px_-30px_rgba(0,0,0,0.25)] transition-all duration-300"
          >
            <section class="overflow-hidden rounded-md">
              <div
                class="relative overflow-hidden bg-slate-200 transition-all duration-300"
              >
                <div
                  class="h-96 w-full bg-gradient-to-br from-teal-50 to-emerald-50 saturate-0 transition-all duration-300 group-hover/card:h-[22rem] group-hover/card:saturate-100"
                ></div>
                <img
                  src="/images/CoverLetterConfig.png"
                  alt="Description"
                  class="absolute -bottom-3 -right-5 max-w-[72%] transition-all duration-300 group-hover/card:translate-y-6"
                />
              </div>
              <div
                class="z-10 bg-white p-8 transition-all duration-300 group-hover/card:pb-2"
              >
                <div class="flex w-full items-center gap-2.5">
                  <Icon
                    icon="solar:letter-opened-bold-duotone"
                    class="h-7 w-7 text-teal-400"
                  />
                  <h3>Personalized Cover Letters</h3>
                </div>
                <p class="mt-4 text-lg leading-7 text-slate-500">
                  Compelling cover letters that highlight why you're the ideal
                  candidate, by taking into account your work-experience,
                  education, motivation and skillset. Lorem ipsum dolor sit,
                  amet consectetur adipisicing elit. Voluptates quam porro
                  reiciendis necessitatibus, temporibus inventore voluptatem
                  consequatur sequi id sint neque dolorum quo dolores! Nemo
                  impedit tenetur laudantium dolorem error? Minus error est, non
                  architecto nulla nostrum iste ad nihil adipisci animi
                  voluptate sed asperiores veritatis aperiam totam odit
                  repudiandae repellendus aut ab quaerat, necessitatibus iusto.
                  Necessitatibus, similique ad. Consectetur.
                </p>
              </div>
              <div
                class="group-hover/card: h-0 bg-white px-8 transition-all duration-300 group-hover/card:h-14"
              >
                <div
                  class="group flex w-fit cursor-pointer items-center gap-1.5 text-teal-500 opacity-0 transition-all duration-150 group-hover/card:opacity-100"
                >
                  <p
                    class="font-semibold transition-all duration-150 group-hover:text-slate-800"
                  >
                    Get Started
                  </p>
                  <p
                    class="group -ml-1 mb-[2px] text-[22px] font-semibold transition-all duration-150 group-hover:ml-0"
                  >
                    <span
                      class="opacity-0 transition-all duration-150 group-hover:text-slate-800 group-hover:opacity-100"
                      >-</span
                    >
                    <span
                      class="-ml-[6px] transition-all duration-150 group-hover:text-slate-800"
                      >›</span
                    >
                  </p>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Icon } from "@iconify/vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const showMenu = ref(false);
</script>
