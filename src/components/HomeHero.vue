<template>
  <section class="relative w-full h-screen overflow-hidden bg-black">
    <!-- Carrusel de imágenes -->
    <div class="relative w-full h-full">
      <transition-group
        name="fade"
        tag="div"
        class="w-full h-full"
      >
        <div
          v-for="(slide, index) in slides"
          v-show="index === currentSlide"
          :key="index"
          class="absolute inset-0"
        >
          <img
            :src="slide.image"
            :alt="slide.title"
            class="w-full h-full object-cover"
          />
          <!-- Overlay oscuro para mejor legibilidad del texto -->
          <div class="absolute inset-0 bg-black/30"></div>
        </div>
      </transition-group>

      <!-- Contenido de texto centrado -->
      <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
        <transition
          name="slide-up"
          mode="out-in"
        >
          <div :key="currentSlide" class="px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-balance">
              {{ slides[currentSlide].title }}
            </h1>
            <p class="text-xl md:text-2xl font-light text-balance">
              {{ slides[currentSlide].subtitle }}
            </p>
          </div>
        </transition>
      </div>
    </div>

    <!-- Dots indicadores -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-10">
      <button
        v-for="(slide, index) in slides"
        :key="`dot-${index}`"
        @click="goToSlide(index)"
        :class="[
          'w-3 h-3 rounded-full transition-all duration-300 cursor-pointer',
          index === currentSlide
            ? 'bg-orange-500 w-8'
            : 'bg-gray-400 hover:bg-gray-300'
        ]"
        :aria-label="`Ir a slide ${index + 1}`"
      ></button>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Estado del carrusel
const currentSlide = ref(0)
let autoPlayInterval = null

// Datos de los slides
const slides = ref([
  {
    image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&h=800&fit=crop',
    title: 'Elegancia Moderna',
    subtitle: 'Espacios de trabajo que inspiran creatividad y productividad'
  },
  {
    image: 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=1200&h=800&fit=crop',
    title: 'Diseño Profesional',
    subtitle: 'Ambientes innovadores para tu empresa'
  },
  {
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=800&fit=crop',
    title: 'Calidad Premium',
    subtitle: 'Construimos espacios de excelencia'
  },
  {
    image: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1200&h=800&fit=crop',
    title: 'Innovación Constante',
    subtitle: 'Soluciones modernas para tus proyectos'
  }
])

// Funciones
const goToSlide = (index) => {
  currentSlide.value = index
  resetAutoPlay()
}

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value.length
}

const resetAutoPlay = () => {
  if (autoPlayInterval) clearInterval(autoPlayInterval)
  autoPlayInterval = setInterval(nextSlide, 5000) // Cambiar cada 5 segundos
}

// Ciclo de vida
onMounted(() => {
  resetAutoPlay()
})

onUnmounted(() => {
  if (autoPlayInterval) clearInterval(autoPlayInterval)
})
</script>

<style scoped>
/* Transición suave de fade entre imágenes */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Transición suave para el texto */
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.6s ease-in-out;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>
