<template>
  <MarketingPagesLayout>
    <Head title="About" />
    <div class="mx-auto h-full w-full bg-slate-50">
      <div
        class="relative mx-auto w-full overflow-hidden bg-gradient-to-br from-emerald-600 to-cyan-500 pb-16 pt-32 md:pb-24 md:pt-52"
      >
        <div class="flex max-w-2xl flex-col p-4 md:mx-auto md:items-center">
          <h1
            class="w-full text-4xl font-bold leading-none tracking-normal text-white md:mb-4 md:w-fit md:text-center md:text-7xl md:tracking-tight"
          >
            Get to
            <br />
            know Jobdeck
          </h1>
          <!-- <h1
            class="text-center font-medium text-white md:text-[82px] md:leading-[1.05]"
          >
            Get to <span class="block"> know Jobdeck </span>
          </h1> -->

          <p class="my-4 text-xl text-white/80 md:my-8 md:text-center">
            The mission, the story and what we value.
          </p>

          <Link
            :href="route('register')"
            class="z-20 inline-block w-fit rounded-lg bg-slate-900 px-4 py-2.5 text-lg font-semibold text-white transition-all duration-200 hover:bg-slate-700"
          >
            Simplify Your Job Search
          </Link>
        </div>
        <!-- <img
          src="https://images.ctfassets.net/ooa29xqb8tix/GerlA3pAOPu0UQe9MKS5h/c9c66952692ea61d3bc795c17f717b3b/Blob_Backgroundnew_image_1.jpg"
          class="absolute origin-center"
        /> -->
      </div>
      <section class="relative w-full overflow-x-hidden p-4">
        <div class="relative z-20 mx-auto w-full max-w-6xl">
          <div class="my-12 md:my-24">
            <p class="mb-4 font-medium uppercase tracking-wider text-teal-500">
              Mission, Values and Goals
            </p>
            <h2
              class="z-20 text-2xl font-medium tracking-tight md:text-4xl md:leading-tight"
            >
              Jobdeck is dedicated to simplifying your job search experience. We
              understand the frustration of managing applications and crafting
              tailored documents, and we're here to make the process effortless
              and effective.
            </h2>
          </div>

          <div
            class="relative mt-24 grid grid-cols-1 gap-8 md:grid-cols-4 lg:grid-cols-8"
          >
            <article
              class="hidden flex-col py-8 md:col-span-2 md:flex lg:col-span-3"
            >
              <p class="mb-4 font-medium tracking-wider">01</p>
              <h3 class="text-3xl font-medium leading-snug">Our Mission</h3>
              <p class="mt-4 text-lg text-slate-600">
                We’re here to take the stress out of job searching. We believe
                that landing your dream job should be simple and accessible for
                everyone, without the mental exhaustion.
              </p>
            </article>
            <article
              class="col-span-3 flex flex-col rounded-xl bg-white p-4 md:hidden md:p-8"
            >
              <p class="mb-4 font-medium tracking-wider">01</p>
              <h3 class="text-3xl font-medium leading-snug">Our Mission</h3>
              <p class="mt-4 text-lg text-slate-600">
                We’re here to take the stress out of job searching. We believe
                that landing your dream job should be simple and accessible for
                everyone, without the mental exhaustion.
              </p>
            </article>
            <article
              class="col-span-3 flex flex-col rounded-xl bg-white p-8 md:col-span-2 lg:col-span-3"
            >
              <p class="mb-4 font-medium tracking-wider">02</p>
              <h3 class="text-3xl font-medium leading-snug">Our Values</h3>
              <p class="mt-4 text-lg text-slate-600">
                We value simplicity, transparency, and support in everything we
                do. We work to empower job seekers by providing the tools they
                need to succeed while listening to their needs. We believe in
                continuous improvement, striving to make the job search process
                easier for everyone, one step at a time.
              </p>
            </article>
            <article
              class="col-span-3 flex flex-col rounded-xl bg-white p-8 md:col-span-4 lg:col-span-3"
            >
              <p class="mb-4 font-medium tracking-wider">03</p>
              <h3 class="text-3xl font-medium leading-snug">Our Goals</h3>
              <p class="mt-4 text-lg text-slate-600">
                We aim to make job searching and application processes easy and
                stress-free for everyone. We believe that by creating a
                user-friendly platform for tracking applications and crafting
                tailored resumes, we can empower our community to achieve their
                career dreams.
              </p>
            </article>
          </div>

          <div class="relative h-[320px] w-full py-12 md:h-[600px] lg:h-0">
            <img
              class="absolute -right-[200px] z-10 w-full min-w-[550px] md:min-w-[800px] lg:-right-[500px] lg:-top-[680px] lg:min-w-[1100px]"
              src="/images/Laptop_Mockup1.png"
              alt=""
            />
          </div>

          <div>
            <p
              class="mb-4 mt-48 font-medium uppercase tracking-wider text-teal-500"
            >
              Development
            </p>
            <h2
              class="z-20 text-2xl font-medium tracking-tight md:text-4xl md:leading-tight"
            >
              Jobdeck is developed by a solo developer working closely with a
              group of friends who actively use and provide feedback on the
              product. We understand our users' needs because we're job seekers
              ourselves, constantly refining the platform based on real-world
              experiences and challenges.
            </h2>
          </div>

          <article class="my-24 w-full rounded-2xl bg-white p-8 md:p-16">
            <img src="/images/Nerenso.jpg" alt="" class="w-44 rounded-full" />

            <div class="mt-12">
              <h3 class="text-4xl font-medium leading-snug tracking-tight">
                Nerenso Mahabir
              </h3>
              <p
                class="font-base mb-8 mt-8 uppercase tracking-wider text-teal-500"
              >
                FOUNDER | DEVELOPER
              </p>

              <article class="space-y-4 text-lg text-slate-600">
                <p>
                  Hey there! I’m a passionate full-stack developer with 12 years
                  of experience under my belt, and I’m on a mission to make
                  landing your dream job a breeze. When I’m not coding away, you
                  might find me tinkering with the latest tech trends or sharing
                  laughs with friends over a cup of coffee (or two!).
                </p>

                <p>
                  Building Jobdeck has been an exciting journey, fueled by my
                  love for creating user-friendly solutions. I believe that
                  finding your dream job shouldn’t feel like climbing a mountain
                  but more like a fun stroll in the park! With the help of my
                  awesome friends who are actively using the platform and giving
                  me invaluable feedback, we’re crafting a tool that truly
                  understands the job seeker’s journey.
                </p>

                <p>
                  Join me as we simplify the job search process and make it a
                  little less daunting and a lot more enjoyable! Let’s turn that
                  dream job into reality, one click at a time!
                </p>
              </article>
            </div>
          </article>

          <div class="mb-28 mt-12">
            <GetStartedCTA />
          </div>
        </div>

        <!-- <img
          class="absolute -right-52 bottom-28 z-10 w-[1100px] md:top-[520px]"
          src="/images/Laptop_Mockup1.png"
          alt=""
        /> -->
      </section>
    </div>
  </MarketingPagesLayout>
</template>

<script setup>
import MarketingPagesLayout from "@/Layouts/MarketingPagesLayout.vue";
import GetStartedCTA from "@/Components/Marketing/Elements/GetStartedCTA.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>
