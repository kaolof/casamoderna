<script setup>
const featured = [
  { id: 1, name: 'Casa Minimalista', location: 'Madrid, España', image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&h=600&fit=crop' },
  { id: 2, name: 'Oficina Ejecutiva', location: 'Barcelona, España', image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=600&fit=crop' },
  { id: 3, name: 'Loft Urbano', location: 'Valencia, España', image: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&h=600&fit=crop' }
]
</script>

<template>
  <section id="projects" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="text-center mb-16">
      <p class="uppercase text-xs tracking-[0.4em] text-gray-500 mb-4">De planos a realidades</p>
      <h2 class="text-3xl md:text-4xl font-semibold text-gray-900">Descubre nuestros proyectos</h2>
    </div>
    <div class="grid gap-6 md:grid-cols-3">
      <article
        v-for="project in featured"
        :key="project.id"
        class="group relative rounded-3xl overflow-hidden"
      >
        <img :src="project.image" :alt="project.name" class="h-80 w-full object-cover group-hover:scale-105 transition duration-300" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
        <div class="absolute bottom-0 p-6 text-white">
          <p class="text-xs uppercase tracking-[0.4em] text-gray-200">Proyecto destacado</p>
          <h3 class="text-2xl font-semibold">{{ project.name }}</h3>
          <p class="text-sm text-gray-200">{{ project.location }}</p>
        </div>
      </article>
    </div>
    <div class="text-center mt-12">
      <button class="border border-gray-900 px-10 py-3 rounded-full uppercase tracking-wide hover:bg-gray-900 hover:text-white transition">
        Ver todos los proyectos
      </button>
    </div>
  </section>
</template>
