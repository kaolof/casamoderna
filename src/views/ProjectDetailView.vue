<script setup>
import { ref, computed } from 'vue'
import HomeNavbar from '../components/HomeNavbar.vue'
import HomeContactFooter from '../components/HomeContactFooter.vue'

const props = defineProps({
  id: {
    type: String,
    required: true
  }
})

// Configuración de proyectos
const projectsData = {
  '1': {
    category: 'CATEGORÍA 1',
    name: 'Tres Pinos',
    heroImage: '/images/trespinos/img1.png',
    client: 'Nombre del cliente',
    year: '2023',
    location: 'LOCDEMÍA',
    area: '2085 M2',
    services: '8',
    description: 'Mosuida dictumst arcu cursus rutrum magna volutpat ornare ac justo lacus, ac mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum eros elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus.',
    descriptionContinued: 'Praesent auctor justo justo sed nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus.',
    galleryImages: [
      '/images/trespinos/img1.png',
      '/images/trespinos/img2.png',
      '/images/trespinos/img3.png',
      '/images/trespinos/img4.png',
      '/images/trespinos/img5.png',
      '/images/trespinos/img6.png',
      '/images/trespinos/img7.png',
      '/images/trespinos/img8.png',
      '/images/trespinos/img9.png'
    ]
  }
}

// Datos de ejemplo para proyectos no configurados
const defaultProject = {
  category: 'CATEGORÍA',
  name: `Nombre del proyecto #${props.id}`,
  heroImage: '/images/portfolioHero.png',
  client: 'Nombre del cliente',
  year: '2023',
  location: 'LOCDEMÍA',
  area: '2085 M2',
  services: '8',
  description: 'Mosuida dictumst arcu cursus rutrum magna volutpat ornare ac justo lacus, ac mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum eros elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus.',
  descriptionContinued: 'Praesent auctor justo justo sed nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus.',
  galleryImages: []
}

const project = computed(() => projectsData[props.id] || defaultProject)

// Debug: verificar qué proyecto se está cargando
console.log('Project ID:', props.id)
console.log('Project data:', project.value)

const relatedProjects = ref([
  {
    id: '1',
    name: 'Tres Pinos',
    image: '/images/trespinos/img1.png'
  },
  {
    id: '2',
    name: 'Nombre del proyecto arquitectónico',
    image: '/images/portfolioHero.png'
  },
  {
    id: '3',
    name: 'Nombre del proyecto arquitectónico',
    image: '/images/portfolioHero.png'
  }
])
</script>

<template>
  <!-- Navbar -->
  <HomeNavbar />

  <!-- Hero Section -->
  <section class="relative w-full h-96">
    <img
      :src="project.heroImage"
      alt="Proyecto"
      class="w-full h-full object-cover"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-8">
      <div class="text-white">
        <p class="text-sm tracking-widest mb-2">{{ project.category }}</p>
        <h1 class="text-4xl font-bold">{{ project.name }}</h1>
      </div>
    </div>
  </section>

   <!-- About Project Section (three columns: title, description, technical card) -->
  <section class="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-[100px_1fr_300px] gap-8 items-start">
    <!-- Column 1: Title with vertical orange bar -->
    <div class="flex items-start py-10">
      <div class="w-3 md:w-4 h-16 md:h-20 bg-orange-500 mr-3 flex-shrink-0"></div>
      <div>
        <h2 class="text-xl font-bold">Acerca del proyecto</h2>
      </div>
    </div>

    <!-- Column 2: Long description -->
    <div class="py-10">
      <p class="text-gray-600 leading-relaxed mb-6">
        {{ project.description }}
      </p>
      <p class="text-gray-600 leading-relaxed">
        {{ project.descriptionContinued }}
      </p>
    </div>

    <!-- Column 3: Technical card -->
    <aside class="p-8 h-fit border border-gray-200" style="background-color: rgba(209,222,222,0.3);">
      <div class="space-y-4">
        <div>
          <p class="text-xs text-gray-500 mb-1">Nombre</p>
          <p class="font-bold text-sm">{{ project.client }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Categoría</p>
          <p class="font-bold text-sm">{{ project.category }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Año</p>
          <p class="font-bold text-sm">{{ project.year }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Ubicación</p>
          <p class="font-bold text-sm">{{ project.location }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Área</p>
          <p class="font-bold text-sm">{{ project.area }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Estructura</p>
          <p class="font-bold text-sm">{{ project.structure ?? '—' }}</p>
        </div>
        <div class="flex gap-6">
          <div>
            <p class="text-xs text-gray-500 mb-1">Habitaciones</p>
            <p class="font-bold text-sm">{{ project.bedrooms ?? '—' }}</p>
          </div>
          <div>
            <p class="text-xs text-gray-500 mb-1">Baños</p>
            <p class="font-bold text-sm">{{ project.bathrooms ?? '—' }}</p>
          </div>
        </div>
      </div>
    </aside>
  </section>

  <!-- Project Gallery -->
  <section class="max-w-7xl mx-auto px-6 py-16">
    <div v-if="project.galleryImages && project.galleryImages.length > 0" class="grid grid-cols-3 gap-4">
      <div v-for="(img, index) in project.galleryImages" :key="index" class="w-full">
        <img
          :src="img"
          :alt="`${project.name} - Imagen ${index + 1}`"
          class="w-full h-64 object-cover"
        />
      </div>
    </div>
    <div v-else class="grid grid-cols-3 gap-4">
      <div v-for="i in 6" :key="i" class="w-full">
        <img
          src="https://via.placeholder.com/300x200.png?text=proyecto"
          alt="Proyecto galería"
          class="w-full h-64 object-cover"
        />
      </div>
    </div>
  </section>

  <!-- Project Plans Section -->
  <!-- <section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center gap-3 mb-12">
        <div class="w-12 h-1 bg-orange-500"></div>
        <h2 class="text-2xl font-bold">Planos del proyecto</h2>
      </div>
      <div class="grid grid-cols-4 gap-4">
        <img
          src="https://via.placeholder.com/200x200.png?text=floor+plan"
          alt="Plano"
          class="w-full h-48 object-cover rounded"
        />
        <img
          src="https://via.placeholder.com/200x200.png?text=architectural+plan"
          alt="Plano"
          class="w-full h-48 object-cover rounded"
        />
        <img
          src="https://via.placeholder.com/200x200.png?text=blueprint"
          alt="Plano"
          class="w-full h-48 object-cover rounded"
        />
        <img
          src="https://via.placeholder.com/200x200.png?text=technical+drawing"
          alt="Plano"
          class="w-full h-48 object-cover rounded"
        />
      </div>
    </div>
  </section> -->

  <!-- Other Projects Section -->
  <section class="max-w-7xl mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Mira otros proyectos</h2>
    <div class="grid grid-cols-3 gap-6">
      <div
        v-for="proj in relatedProjects"
        :key="proj.id"
        class="relative group overflow-hidden rounded"
      >
        <img
          :src="proj.image"
          alt="Proyecto relacionado"
          class="w-full h-64 object-cover group-hover:opacity-80 transition-opacity"
        />
        <div class="absolute inset-0 bg-opacity-40 flex flex-col justify-end p-6 text-white">
          <h3 class="font-bold">{{ proj.name }}</h3>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section (reutilizando homeContactFooter) -->
  <HomeContactFooter />
</template>
