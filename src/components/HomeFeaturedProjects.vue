<template>
  <section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-16">
        <p class="text-sm font-semibold tracking-widest text-gray-600 mb-4">DE PLANOS A REALIDADES</p>
        <h2 class="text-5xl md:text-6xl font-bold text-black">Descubre nuestros proyectos</h2>
      </div>

      <!-- Projects Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div
          v-for="(project, index) in projects"
          :key="index"
          class="relative h-80 overflow-hidden group cursor-pointer"
        >
          <!-- Background Image -->
          <div
            class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
            :style="{ backgroundImage: `url(${project.image})` }"
          ></div>

          <!-- Overlay -->
          <div class="absolute inset-0 bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>

          <!-- Content -->
          <div class="absolute inset-0 flex flex-col justify-end p-8">
            <p class="text-white text-sm font-semibold tracking-widest mb-2">{{ project.category }}</p>
            <h3 class="text-white text-2xl font-bold">{{ project.title }}</h3>
          </div>
        </div>
      </div>

      <!-- Button -->
      <div class="flex justify-center">
        <button class="px-12 py-4 border-2 border-black text-black font-bold tracking-widest hover:bg-black hover:text-white transition-all duration-300">
          VER TODOS LOS PROYECTOS
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
const projects = [
  {
    category: 'CATEGORÍA',
    title: 'Nombre del proyecto arquitectónico',
    image: 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=600&h=400&fit=crop'
  },
  {
    category: 'CATEGORÍA',
    title: 'Nombre del proyecto arquitectónico',
    image: 'https://images.unsplash.com/photo-1565621981027-f127ff144326?w=600&h=400&fit=crop'
  },
  {
    category: 'CATEGORÍA',
    title: 'Nombre del proyecto arquitectónico',
    image: 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&h=400&fit=crop'
  }
]
</script>

<style scoped>
section {
  background-color: #f9f9f9;
}
</style>
