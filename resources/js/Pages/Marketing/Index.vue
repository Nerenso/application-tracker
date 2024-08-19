<template>
  <Head title="Home" />
  <div class="landing-page min-h-screen w-full">
    <header
      class="relative h-[900px] w-full bg-gradient-to-b from-emerald-500 to-teal-500"
    >
      <nav class="py-8">
        <div
          class="mx-auto flex w-full max-w-6xl items-center justify-between rounded-xl bg-white px-6 py-4 shadow-xl shadow-black/15"
        >
          <Link href="/"> <AppLogo class="w-[112px]" /></Link>
          <div>
            <Link :href="route('login')">Login</Link>
            <Link :href="route('register')">Register</Link>
          </div>
        </div>
      </nav>
      <section class="mx-auto w-full max-w-6xl p-4 pt-16">
        <article class="mb-20">
          <p class="mb-6 text-center text-white/80">Introducing Jobdeck</p>
          <h2 class="mb-4 text-center text-5xl text-white">
            Job Hunting the Smart Way
          </h2>
          <p
            class="mx-auto max-w-3xl text-center text-lg font-medium text-white/90"
          >
            Exhausted, overwhelmed and frustrated? We got your back!
            Effortlessly track your job applications, get your cover letters and
            custom tailored resumes written to perfectly fit the job you're
            looking for.
          </p>

          <div
            class="mx-auto mt-10 flex w-full max-w-sm items-center justify-center gap-4 font-medium text-white/85"
          >
            <button class="rounded-lg bg-white/30 px-4 py-2.5 text-lg">
              Learn More
            </button>
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

    <div class="max-w-sm">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui magni nihil
      eligendi earum assumenda illum totam eum nesciunt. Reiciendis, earum?
      Itaque odit, in exercitationem soluta accusamus vitae error sed culpa?
      Cupiditate voluptatibus vero a, illum modi dicta possimus. Quam ducimus
      delectus modi necessitatibus nesciunt dicta praesentium quasi, nobis
      consectetur voluptatibus soluta sint aspernatur nostrum quae nisi tenetur
      sed vero incidunt? Doloremque numquam laborum adipisci dolor laboriosam,
      nihil ut rem quis cupiditate esse reprehenderit sequi magni veritatis
      mollitia amet in harum voluptate. Voluptatum incidunt praesentium ipsum
      autem eaque eligendi blanditiis est. Magnam, quo. Aspernatur mollitia
      soluta hic commodi quaerat, quasi dolore reiciendis numquam harum, non
      maxime corrupti ducimus accusamus explicabo tempora voluptatum tenetur
      sequi minima iure aut repellat ipsam. Consectetur, quibusdam! Molestiae
      eius asperiores eveniet recusandae veniam expedita rerum quisquam
      architecto, aspernatur praesentium maiores dicta ab eligendi! Corrupti,
      natus dolores recusandae soluta exercitationem sunt neque cum? Eos
      suscipit expedita deserunt fugit? Eaque, maiores libero nulla ipsa earum,
      ad corporis dolor non mollitia repellendus, facilis quidem voluptas
      nostrum. Sed accusamus a aliquam magnam reiciendis libero consequuntur,
      quibusdam dicta nihil quidem aut! Aliquid! Molestiae excepturi voluptatem
      eos aspernatur, nostrum officia inventore ipsam saepe in deserunt laborum
      eligendi soluta reiciendis vitae ipsa quo illo aliquid cupiditate aut vero
      sequi. Assumenda quo consequatur nihil expedita. Porro rem in libero sint
      dicta reiciendis exercitationem possimus repellendus, est pariatur omnis
      hic amet modi recusandae dolore, iure quisquam saepe non! Ipsa labore quam
      excepturi aliquid blanditiis! Repellat, quidem? Dolorem beatae blanditiis
      provident consectetur! Enim, totam! Iure, soluta fuga, itaque possimus
      nulla eius pariatur blanditiis assumenda ipsum voluptatibus quod
      cupiditate odio hic veniam debitis quidem. Cumque beatae velit eligendi!
      Eum, cupiditate non iste, veritatis quisquam recusandae fugiat sequi
      perferendis delectus sit quis neque earum eius, explicabo impedit labore
      tempore atque fugit! Possimus doloribus non laboriosam est velit, quod
      voluptas.
    </div>
  </div>
</template>

<script setup>
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>
