<script setup>
const categories = ['CATEGORÍA 1','CATEGORÍA 2','CATEGORÍA 3','CATEGORÍA 4','CATEGORÍA 5']

// Repetimos la misma imagen de ejemplo por ahora; puedes reemplazarlas por rutas reales.
const images = Array.from({ length: 9 }).map(() => '/images/portfolioHero.png')
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
      <div v-for="(src, idx) in images" :key="idx" class="relative overflow-hidden border border-gray-200 group cursor-pointer">
        <img :src="src" alt="proyecto" class="w-full h-48 md:h-56 lg:h-64 object-cover block" />

        <!-- Overlay on hover: reveal with left->right wipe -->
        <div class="absolute inset-0 flex items-center justify-start">
          <!-- White panel with orange stripe that expands from left to right -->
          <div class="relative ml-4 h-auto w-0 group-hover:w-90 transition-all duration-300 ease-out overflow-hidden">
            <!-- White background container with shadow -->
            <div class="bg-white shadow-lg flex items-stretch h-full min-h-[120px]">
              <!-- Orange stripe on the left, full height -->
              <div class="w-3 bg-orange-500 flex-shrink-0 self-stretch"></div>
              <!-- Text content that appears after animation -->
              <div class="pl-6 pr-8 py-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200 delay-300">
                <p class="text-xs uppercase text-gray-500 tracking-wider mb-1">CATEGORÍA</p>
                <h3 class="text-base font-bold whitespace-nowrap">Nombre del proyecto arquitectonico</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<!-- No additional styles; relies on Tailwind in the project -->
