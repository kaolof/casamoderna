<script setup>
const categories = ['CATEGORÍA 1','CATEGORÍA 2','CATEGORÍA 3','CATEGORÍA 4','CATEGORÍA 5']

// Proyectos configurados
const projects = [
  {
    id: '1',
    category: 'CATEGORÍA 1',
    name: 'Tres Pinos',
    src: '/images/trespinos/img1.png'
  },
  ...Array.from({ length: 8 }).map((_, i) => ({
    id: String(i + 2),
    category: `CATEGORÍA ${((i % 5) + 1)}`,
    name: 'Nombre del proyecto arquitectonico',
    src: '/images/portfolioHero.png'
  }))
]
</script>

<template>
  <section class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-sm font-semibold tracking-wide">TODOS LOS PROYECTOS</h2>
      <nav class="space-x-4 text-sm">
        <button v-for="(c, i) in categories" :key="i" class="text-black hover:text-orange-500 transition-colors">{{ c }}</button>
      </nav>
    </div>
    <hr class="border-t border-black mb-6" />
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <router-link
        v-for="(project, idx) in projects"
        :key="project.id"
        :to="{ name: 'project-detail', params: { id: project.id } }"
        class="relative overflow-hidden border border-gray-200 group cursor-pointer block"
      >
        <img :src="project.src" :alt="project.name" class="w-full h-48 md:h-56 lg:h-64 object-cover block" />

        <!-- Overlay on hover: reveal with left->right wipe -->
        <div class="absolute inset-0 flex items-center justify-start">
          <!-- White panel with orange stripe that expands from left to right -->
          <div class="relative ml-4 h-auto w-0 group-hover:w-80 transition-all duration-300 ease-out overflow-hidden">
            <!-- White background container with shadow -->
            <div class="bg-white shadow-lg flex items-stretch h-full min-h-[120px]">
              <!-- Orange stripe on the left, full height -->
              <div class="w-3 bg-orange-500 flex-shrink-0 self-stretch"></div>
              <!-- Text content that appears after animation -->
              <div class="pl-6 pr-8 py-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200 delay-300">
                <p class="text-xs uppercase text-gray-500 tracking-wider mb-1">{{ project.category }}</p>
                <h3 class="text-base font-bold">{{ project.name }}</h3>
              </div>
            </div>
          </div>
        </div>
      </router-link>
    </div>
  </section>
</template>

<!-- No additional styles; relies on Tailwind in the project -->
