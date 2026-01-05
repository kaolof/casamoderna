<template>
  <section :class="['relative w-full overflow-hidden', heightClasses]">
    <!-- Background Image -->
    <img
      :src="imageSrc"
      :alt="imageAlt"
      class="absolute inset-0 w-full h-full object-cover object-center transform scale-105"
    />

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Content -->
    <div class="relative h-full flex items-center px-6 md:px-12 lg:px-24">
      <div class="max-w-3xl">
        <!-- Title -->
        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight tracking-tight drop-shadow-lg pr-4 md:pr-8">
          {{ title }}
        </h2>

        <!-- Description -->
        <p class="text-sm md:text-base text-white/90 mb-6 leading-relaxed pr-8">
          {{ description }}
        </p>

        <!-- Button -->
        <template v-if="buttonHref">
          <a
            :href="buttonHref"
            aria-label="cta-link"
            class="inline-block border-2 border-white text-white px-6 py-2 md:px-8 md:py-3 text-sm md:text-base font-semibold uppercase tracking-wider hover:bg-white hover:text-black transition-colors duration-300"
          >
            {{ buttonText }}
          </a>
        </template>
        <template v-else>
          <button
            @click="$emit('cta')"
            aria-label="cta-button"
            class="inline-block border-2 border-white text-white px-6 py-2 md:px-8 md:py-3 text-sm md:text-base font-semibold uppercase tracking-wider hover:bg-white hover:text-black transition-colors duration-300"
          >
            {{ buttonText }}
          </button>
        </template>
      </div>
    </div>
  </section>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Descubre cómo hemos transformado ideas en espacios únicos',
  },
  description: {
    type: String,
    default:
      'Accede a nuestro portafolio privado y conoce ejemplos reales de viviendas, oficinas y desarrollos arquitectónicos que hemos diseñado.',
  },
  buttonText: {
    type: String,
    default: 'VER PORTAFOLIO',
  },
  buttonHref: {
    type: String,
    default: '',
  },
  imageSrc: {
    type: String,
    default: '/images/image.svg',
  },
  imageAlt: {
    type: String,
    default: 'Interior moderno',
  },
  heightClasses: {
    type: String,
    default: 'h-[450px] md:h-[550px]',
  },
})

defineEmits(['cta'])
</script>

<style scoped>
/* Estilos opcionales personalizados */
</style>
