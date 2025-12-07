<script setup>
import HomeNavbar from '../components/HomeNavbar.vue'
import PortfolioGallery from '../components/PortfolioGallery.vue'
import HomeContactFooter from '../components/HomeContactFooter.vue'
</script>

<template>
  <div class="bg-white min-h-screen">
    <HomeNavbar />
    <!-- Hero section for Portfolio -->
    <section
      class="relative h-80 md:h-96 flex items-center justify-center text-center text-white"
      role="img"
      aria-label="Portafolio hero"
      style="background-image: url('/images/portfolioHero.png'); background-size: cover; background-position: center;">
      <!-- Darken the image slightly -->
      <div class="absolute inset-0 bg-black/30"></div>

      <!-- White gradient at the bottom so the image fades into the page -->
      <div class="absolute left-0 right-0 bottom-0 h-48 bg-gradient-to-b from-transparent to-white pointer-events-none"></div>

      <div class="relative z-20 px-4">
        <h1 class="text-3xl md:text-5xl font-bold">Portafolio</h1>
      </div>
    </section>

    <main>
      <PortfolioGallery />

      <HomeContactFooter />
    </main>
  </div>
</template>
