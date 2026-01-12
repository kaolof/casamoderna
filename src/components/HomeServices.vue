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
        <div v-for="service in services" :key="service.id" class="bg-gray-100 p-5">
          <component :is="service.icon" class="w-8 h-8 text-orange-500 mb-3" />
          <h3 class="font-bold text-black mb-3">{{ service.name }}</h3>
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
import { Building2, Ruler, Wrench, Package, FolderKanban, Handshake } from 'lucide-vue-next'

const services = [
  {
    id: 1,
    icon: Building2,
    name: 'Obras',
    description: 'Ejecutamos obras civiles y proyectos constructivos de forma integral o parcial, garantizando calidad, coordinación técnica y cumplimiento de plazos en proyectos residenciales, comerciales e industriales.'
  },
  {
    id: 2,
    icon: Ruler,
    name: 'Arquitectura e Ingeniería',
    description: 'Desarrollamos proyectos de arquitectura e ingeniería con soluciones funcionales, seguras y viables, alineando diseño, normativa y ejecución para una correcta materialización del proyecto.'
  },
  {
    id: 3,
    icon: Wrench,
    name: 'Mantenimientos',
    description: 'Brindamos mantenimiento integral preventivo, correctivo y programado para edificaciones e instalaciones, asegurando su óptimo funcionamiento y conservación según cada necesidad operativa.'
  },
  {
    id: 4,
    icon: Package,
    name: 'Suministros',
    description: 'Gestionamos el suministro de bienes, materiales, equipos, personal y recursos logísticos, ofreciendo soluciones flexibles, oportunas y adaptadas a cada proyecto o contrato.'
  },
  {
    id: 5,
    icon: FolderKanban,
    name: 'Gestión de Proyectos',
    description: 'Administramos proyectos de manera técnica, operativa y administrativa, optimizando costos, tiempos y procesos, y asegurando el cumplimiento de los lineamientos contractuales y licitatorios.'
  },
  {
    id: 6,
    icon: Handshake,
    name: 'Modelo de Gestión Integral',
    description: 'Ofrecemos un modelo integral que reduce intermediarios y mejora el control de calidad, costos y ejecución, adaptándonos a proyectos de distintas escalas.'
  }
]
</script>

<style scoped>
</style>
