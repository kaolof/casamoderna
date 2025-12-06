<template>
  <section class="relative w-full h-96 md:h-screen overflow-hidden">
    <!-- Background Image -->
    <img
      src="/images/image.svg"
      alt="Interior moderno"
      class="absolute inset-0 w-full h-full object-cover"
    />

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Content -->
    <div class="relative h-full flex items-center px-8 md:px-16 lg:px-24">
      <div class="max-w-2xl">
        <!-- Title -->
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
          Descubre cómo hemos transformado ideas en espacios únicos
        </h2>

        <!-- Description -->
        <p class="text-lg md:text-xl text-white/90 mb-8 leading-relaxed">
          Accede a nuestro portafolio privado y conoce ejemplos reales de viviendas, oficinas y desarrollos arquitectónicos que hemos diseñado.
        </p>

        <!-- Button -->
        <button
          class="border-2 border-white text-white px-8 py-3 text-lg font-semibold hover:bg-white hover:text-black transition-colors duration-300"
        >
          VER PORTAFOLIO
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
// No necesita lógica especial, es una sección estática
</script>

<style scoped>
/* Estilos opcionales personalizados */
</style>
