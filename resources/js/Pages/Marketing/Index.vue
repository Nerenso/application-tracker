<template>
  <Head title="Home" />
  <div class="min-h-screen w-full">
    <header class="w-full bg-gradient-to-b to-teal-500 from-emerald-500 h-[900px] relative">
      <nav class="py-8">
        <div class="shadow-xl shadow-black/15 mx-auto bg-white max-w-6xl w-full py-4 px-6 flex items-center justify-between rounded-xl">
          <Link href="/"> <AppLogo class="w-[112px]" /></Link>
          <div>
            <Link :href="route('login')">Login</Link>
          </div>
        </div>
      </nav>
      <section class="mx-auto max-w-6xl w-full pt-20 p-4">
        <article class="mb-20">
          <p class="text-center text-white/80 mb-6">Introducing Jobdeck</p>
          <h2 class="text-white text-center text-5xl mb-4">Job Hunting the Smart Way</h2>
          <p class="text-lg font-medium text-white/90 text-center max-w-3xl mx-auto">
            Exhausted, overwhelmed and frustrated? We got your back! Effortlessly track your job applications, get your cover letters and custom
            tailored resumes written to perfectly fit the job you're looking for.
          </p>

          <div class="mt-10 font-medium mx-auto max-w-sm w-full text-white/85 flex items-center justify-center gap-4">
            <button class="px-4 py-2.5 text-lg bg-white/30 rounded-lg">Learn More</button>
            <button class="px-4 py-2.5 text-lg bg-slate-900 rounded-lg">Get Started</button>
          </div>
        </article>
      </section>

      <div class="absolute w-full px-4 flex overflow-auto">
        <!-- <div class="w-full min-w-[800px] max-w-6xl h-[600px] mx-auto flex-shrink-0 bg-gradient-to-tr from-orange-500 to-rose-600"></div> -->
        <img
          src="/images/Jobdeck-Dashboard.png"
          alt=""
          class="w-full mx-auto mb-20 flex-shrink-0 min-w-[800px] max-w-6xl rounded-2xl shadow-2xl shadow-black/40"
        />
        <!-- <div class="-bottom-96 w-full mr-5">

        </div> -->
      </div>
    </header>

    <div class="max-w-sm">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui magni nihil eligendi earum assumenda illum totam eum nesciunt. Reiciendis, earum?
      Itaque odit, in exercitationem soluta accusamus vitae error sed culpa? Cupiditate voluptatibus vero a, illum modi dicta possimus. Quam ducimus
      delectus modi necessitatibus nesciunt dicta praesentium quasi, nobis consectetur voluptatibus soluta sint aspernatur nostrum quae nisi tenetur
      sed vero incidunt? Doloremque numquam laborum adipisci dolor laboriosam, nihil ut rem quis cupiditate esse reprehenderit sequi magni veritatis
      mollitia amet in harum voluptate. Voluptatum incidunt praesentium ipsum autem eaque eligendi blanditiis est. Magnam, quo. Aspernatur mollitia
      soluta hic commodi quaerat, quasi dolore reiciendis numquam harum, non maxime corrupti ducimus accusamus explicabo tempora voluptatum tenetur
      sequi minima iure aut repellat ipsam. Consectetur, quibusdam! Molestiae eius asperiores eveniet recusandae veniam expedita rerum quisquam
      architecto, aspernatur praesentium maiores dicta ab eligendi! Corrupti, natus dolores recusandae soluta exercitationem sunt neque cum? Eos
      suscipit expedita deserunt fugit? Eaque, maiores libero nulla ipsa earum, ad corporis dolor non mollitia repellendus, facilis quidem voluptas
      nostrum. Sed accusamus a aliquam magnam reiciendis libero consequuntur, quibusdam dicta nihil quidem aut! Aliquid! Molestiae excepturi
      voluptatem eos aspernatur, nostrum officia inventore ipsam saepe in deserunt laborum eligendi soluta reiciendis vitae ipsa quo illo aliquid
      cupiditate aut vero sequi. Assumenda quo consequatur nihil expedita. Porro rem in libero sint dicta reiciendis exercitationem possimus
      repellendus, est pariatur omnis hic amet modi recusandae dolore, iure quisquam saepe non! Ipsa labore quam excepturi aliquid blanditiis!
      Repellat, quidem? Dolorem beatae blanditiis provident consectetur! Enim, totam! Iure, soluta fuga, itaque possimus nulla eius pariatur
      blanditiis assumenda ipsum voluptatibus quod cupiditate odio hic veniam debitis quidem. Cumque beatae velit eligendi! Eum, cupiditate non iste,
      veritatis quisquam recusandae fugiat sequi perferendis delectus sit quis neque earum eius, explicabo impedit labore tempore atque fugit!
      Possimus doloribus non laboriosam est velit, quod voluptas.
    </div>
  </div>
</template>

<script setup>
import AppLogo from "@/Components/UI/AppLogo.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>
