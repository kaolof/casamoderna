<template>
  <section id="services" class="w-full bg-white py-20 px-4 scroll-mt-20">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12 px-4 sm:px-0">
        <p class="text-gray-500 text-sm font-medium tracking-wider mb-4">LO QUE HACEMOS</p>
        <h2 class="text-2xl md:text-5xl font-bold text-black text-balance">
          Soluciones arquitectónicas<br class="hidden md:block"/>a tu medida
        </h2>
      </div>

      <!-- Services Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div v-for="service in services" :key="service.id" class="bg-gray-100 p-8">
          <p class="text-2xl mb-3">★</p>
          <h3 class="font-bold text-black mb-3">SERVICIOS</h3>
          <p class="text-gray-600 text-sm leading-relaxed">{{ service.description }}</p>
        </div>
      </div>

      <!-- CTA Button -->
      <div class="flex justify-center">
        <button class="px-8 py-4 border-2 border-black text-black font-bold text-sm tracking-wider hover:bg-black hover:text-white transition-all duration-300">
          SOLICITA UNA COTIZACIÓN
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
const services = [
  {
    id: 1,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  },
  {
    id: 2,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  },
  {
    id: 3,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  },
  {
    id: 4,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  },
  {
    id: 5,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  },
  {
    id: 6,
    description: 'Yorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis'
  }
]
</script>

<style scoped>
</style>
