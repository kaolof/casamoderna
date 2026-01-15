<script setup>
import HomeNavbar from '../components/HomeNavbar.vue'
import HomeHero from '../components/HomeHero.vue'
import HomeAbout from '../components/HomeAbout.vue'
import HomeProjects from '../components/HomeProjects.vue'
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
      <HomeProjects 
        :image-src="'/images/home/cta1.jpg'"
        button-href="/proyectos"
      />
      <HomeServices />
      <!-- Reutilización del componente HomeProjects con contenido distinto -->
      <HomeProjects
        title="Hablemos de tu proyecto, convierte tu idea en una realidad"
        description="Agenda una llamada o reunión con nuestros arquitectos para conocer de cerca tu 
                    idea y orientarte en los primeros pasos."
        button-text="AGENDAR REUNIÓN"
        :image-src="'/images/home/cta2.jpg'"
        image-alt="Proyecto residencial"
        button-href="#contact"
      />
      <HomeFeaturedProjects />
      <HomeTestimonials />
      <HomeContactFooter />
    </main>
  </div>
</template>
