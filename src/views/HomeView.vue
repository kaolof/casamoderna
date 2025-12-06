<script setup>
import HomeNavbar from '../components/HomeNavbar.vue'
import HomeHero from '../components/HomeHero.vue'
import HomeAbout from '../components/HomeAbout.vue'
import HomeTransitionCTA from '../components/HomeProyectos.vue'
import HomeServices from '../components/HomeServices.vue'
import HomeFeaturedProjects from '../components/HomeFeaturedProjects.vue'
import HomeTestimonials from '../components/HomeTestimonials.vue'
import HomeContactFooter from '../components/HomeContactFooter.vue'
</script>

<template>
  <div class="bg-white min-h-screen">
    <HomeNavbar />
    <main>
      <HomeHero />
      <HomeAbout />
      <HomeTransitionCTA />
      <HomeServices />
      <HomeFeaturedProjects />
      <HomeTestimonials />
      <HomeContactFooter />
    </main>
  </div>
</template>
