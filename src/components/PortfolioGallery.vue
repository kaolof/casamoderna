<script setup>
import { ref, onMounted } from 'vue'

const categories = ['CATEGORÍA 1','CATEGORÍA 2','CATEGORÍA 3','CATEGORÍA 4','CATEGORÍA 5']

// Proyectos desde la API
const projects = ref([])
const isLoading = ref(true)

// Consumir API de WordPress
onMounted(async () => {
  try {
    const response = await fetch('https://cms.construcasamoderna.com/wp-json/wp/v2/proyecto')
    const data = await response.json()
    console.log('Cantidad de proyectos en la API:', data.length)
    
    // Mapear los datos de la API al formato del componente
    projects.value = await Promise.all(data.map(async (project) => {
      let imageUrl = '/images/portfolioHero.png' // Imagen por defecto
      
      // Si tiene imagen principal, obtenerla
      const imageId = project.acf?.['image-main']
      if (imageId) {
        try {
          const imgResponse = await fetch(`https://cms.construcasamoderna.com/wp-json/wp/v2/media/${imageId}`)
          const imgData = await imgResponse.json()
          imageUrl = imgData.source_url || imageUrl
        } catch (error) {
          console.error(`Error al cargar imagen ${imageId}:`, error)
        }
      }
      
      return {
        id: project.id,
        slug: project.slug,
        title: project.title.rendered,
        description: project.acf?.['descripcion-proyecto'] || '',
        year: project.acf?.['year-proyecto'] || '',
        image: imageUrl
      }
    }))
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
          <div class="relative ml-4 h-auto w-0 group-hover:w-90 transition-all duration-300 ease-out overflow-hidden">
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
