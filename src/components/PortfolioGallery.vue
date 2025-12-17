<script setup>
import { ref, onMounted } from 'vue'

const API_BASE_URL = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`

const categories = ['CATEGORÍA 1','CATEGORÍA 2','CATEGORÍA 3','CATEGORÍA 4','CATEGORÍA 5']

// Proyectos desde la API
const projects = ref([])
const isLoading = ref(true)

// Consumir API de WordPress
onMounted(async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/proyecto`)
    const data = await response.json()
    console.log('Cantidad de proyectos en la API:', data.length)
    
    // Primero mapear proyectos sin imágenes
    projects.value = data.map((project) => ({
      id: project.id,
      slug: project.slug,
      title: project.title.rendered,
      description: project.acf?.['descripcion-proyecto'] || '',
      year: project.acf?.['year-proyecto'] || '',
      image: '/images/portfolioHero.png' // Temporal
    }))
    
    // Recolectar todos los IDs de imágenes únicos
    const imageIds = [...new Set(
      data
        .map(p => p.acf?.['image-main'])
        .filter(id => id)
    )]
    
    console.log('IDs de imágenes a cargar:', imageIds.length)
    
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
        const imageId = originalProject?.acf?.['image-main']
        
        return {
          ...project,
          image: imageMap[imageId] || project.image
        }
      })
    }
  } catch (error) {
    console.error('Error al consumir la API:', error)
  } finally {
    isLoading.value = false
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
                <p class="text-xs uppercase text-gray-500 tracking-wider mb-1">{{ project.year }}</p>
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
