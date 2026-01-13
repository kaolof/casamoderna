<script setup>
import { ref, onMounted } from 'vue'

const API_BASE_URL = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`

const categories = ['CATEGORÍA 1','CATEGORÍA 2','CATEGORÍA 3','CATEGORÍA 4','CATEGORÍA 5']

// Proyectos desde la API
const projects = ref([])
const isLoading = ref(true)

// Datos de prueba para testear
const mockProjects = [
  {
    id: 1,
    slug: 'casa-moderna-residencial',
    title: 'Casa Moderna Residencial',
    category: 'RESIDENCIAL',
    description: 'Proyecto de construcción de una casa moderna con diseño minimalista, amplios espacios y acabados de primera calidad.',
    year: '2024',
    image: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80'
  }
]

// Consumir API de WordPress
onMounted(async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/proyecto`)
    const data = await response.json()
    
    // Primero mapear proyectos sin imágenes
    projects.value = data.map((project) => ({
      id: project.id,
      slug: project.slug,
      title: project.title.rendered,
      category: project.acf?.categoria || 'PROYECTO',
      description: project.acf?.['descripcion-proyecto'] || '',
      year: project.acf?.['year-proyecto'] || '',
      image: '/images/portfolioHero.png' // Temporal
    }))
    
    // Recolectar todos los IDs de imágenes únicos (usar imagen1 como portada)
    const imageIds = [...new Set(
      data
        .map(p => p.acf?.imagenes?.imagen1)
        .filter(id => id)
    )]
    
    // Cargar todas las imágenes en UNA SOLA llamada usando el parámetro include
    if (imageIds.length > 0) {
      const imgResponse = await fetch(
        `${API_BASE_URL}/media?include=${imageIds.join(',')}&per_page=100`
      )
      const images = await imgResponse.json()
      
      // Crear mapa de ID -> URL para búsqueda rápida
      const imageMap = {}
      images.forEach(img => {
        imageMap[img.id] = img.source_url
      })
      
      // Actualizar proyectos con las URLs de imágenes
      projects.value = projects.value.map((project) => {
        const originalProject = data.find(p => p.id === project.id)
        const imageId = originalProject?.acf?.imagenes?.imagen1
        
        return {
          ...project,
          image: imageMap[imageId] || project.image
        }
      })
    }
  } catch (error) {
    console.error('Error al consumir la API:', error)
    // Si hay error o no hay datos, usar proyectos de prueba
    if (projects.value.length === 0) {
      projects.value = mockProjects
    }
  } finally {
    isLoading.value = false
    // Si después de todo no hay proyectos, usar mock
    if (projects.value.length === 0) {
      projects.value = mockProjects
    }
  }
})
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
    
    <!-- Loading State -->
    <div v-if="isLoading" class="flex items-center justify-center min-h-[400px]">
      <div class="text-center">
        <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-orange-500 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
          <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Cargando...</span>
        </div>
        <p class="mt-4 text-gray-600 font-medium">Cargando...</p>
      </div>
    </div>

    <!-- No Projects State -->
    <div v-else-if="projects.length === 0" class="flex items-center justify-center min-h-[400px]">
      <div class="text-center">
        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay proyectos disponibles</h3>
        <p class="text-gray-600">Actualmente no hay proyectos para mostrar.</p>
      </div>
    </div>

    <!-- Projects Grid -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <router-link 
        v-for="project in projects" 
        :key="project.id"
        :to="{ name: 'project-detail', params: { id: project.id } }"
        class="relative overflow-hidden border border-gray-200 group cursor-pointer block"
      >
        <img :src="project.image" :alt="project.title" class="w-full h-48 md:h-56 lg:h-64 object-cover block" />

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
                <p class="text-xs uppercase text-gray-500 tracking-wider mb-1">{{ project.category }} · {{ project.year }}</p>
                <h3 class="text-base font-bold whitespace-nowrap">{{ project.title }}</h3>
              </div>
            </div>
          </div>
        </div>
      </router-link>
    </div>
  </section>
</template>

<!-- No additional styles; relies on Tailwind in the project -->
