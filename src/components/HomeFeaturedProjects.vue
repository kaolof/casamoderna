<template>
  <section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-16">
        <p class="text-sm font-semibold tracking-widest text-gray-600 mb-4">DE PLANOS A REALIDADES</p>
        <h2 class="text-5xl md:text-6xl font-bold text-black">Mira nuestro portafolio</h2>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="flex items-center justify-center py-20">
        <div class="text-center">
          <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-orange-500 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Cargando...</span>
          </div>
          <p class="mt-4 text-gray-600 font-medium">Cargando...</p>
        </div>
      </div>

      <!-- Projects Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <router-link
          v-for="(project, index) in projects"
          :key="project.id"
          :to="`/proyectos/${project.id}`"
          class="relative h-80 overflow-hidden group cursor-pointer bg-gray-800"
        >
          <!-- Background Image -->
          <img
            v-if="project.image"
            :src="project.image"
            :alt="project.title"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            @error="handleImageError($event, index)"
          />

          <!-- Overlay sutil solo en la parte inferior para mejorar legibilidad del texto -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent group-hover:from-black/80 transition-all duration-300"></div>

          <!-- Content -->
          <div class="absolute inset-0 flex flex-col justify-end p-8 z-10">
            <p class="text-white text-sm font-semibold tracking-widest mb-2 uppercase">{{ project.category }}</p>
            <h3 class="text-white text-2xl font-bold">{{ project.title }}</h3>
          </div>
        </router-link>
      </div>

      <!-- Button -->
      <div class="flex justify-center">
        <router-link to="/proyectos" class="px-12 py-4 border-2 border-black text-black font-bold tracking-widest hover:bg-black hover:text-white transition-all duration-300">
          PORTAFOLIO
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const API_BASE_URL = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`

const projects = ref([])
const isLoading = ref(true)

// Imagen por defecto
const DEFAULT_IMAGE = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&h=600&fit=crop'

// Manejar error de imagen
const handleImageError = (event, index) => {
  console.log('Error cargando imagen, usando respaldo')
  event.target.src = DEFAULT_IMAGE
}

// Helper function para cargar una imagen
const fetchImageUrl = async (imageId) => {
  if (!imageId) return DEFAULT_IMAGE
  try {
    const response = await fetch(`${API_BASE_URL}/media/${imageId}`)
    if (!response.ok) return DEFAULT_IMAGE
    const data = await response.json()
    return data.source_url || DEFAULT_IMAGE
  } catch (error) {
    console.error(`Error al cargar imagen ${imageId}:`, error)
    return DEFAULT_IMAGE
  }
}

// Cargar proyectos destacados desde la API
onMounted(async () => {
  try {
    // Obtener los primeros 3 proyectos (con _embed para obtener términos/taxonomías)
    const response = await fetch(`${API_BASE_URL}/proyecto?per_page=3&_embed`)
    const projectsData = await response.json()

    // Cargar todas las imágenes en paralelo (usar imagen1 como portada)
    const imageIds = projectsData
      .map(p => p.acf?.imagenes?.imagen1)
      .filter(Boolean)

    const imageUrls = await Promise.all(
      imageIds.map(id => fetchImageUrl(id))
    )

    // Helper para extraer la categoría desde _embedded (robusto)
    const getCategoryFromEmbedded = (project) => {
      try {
        const termsGroup = project._embedded && project._embedded['wp:term']
        if (Array.isArray(termsGroup)) {
          for (const group of termsGroup) {
            if (Array.isArray(group) && group.length > 0) {
              const term = group.find(t => t && t.name)
              if (term) return term.name
            }
          }
        }
      } catch (e) {
        // ignore
      }
      return null
    }

    // Mostrar en consola para depuración
    console.log('Raw proyectos response (for debugging _embedded):', projectsData)

    // Mapear proyectos con sus imágenes y categoría (fallbacks adicionales)
    projects.value = projectsData.map((project, idx) => {
      const embeddedCategory = getCategoryFromEmbedded(project)
      const acfCategory = project.acf?.categoria || project.acf?.categoria_nombre || null
      const category = embeddedCategory || acfCategory || 'PROYECTO'
      console.log(`Project ${project.id} -> embeddedCategory:`, embeddedCategory, 'acfCategory:', acfCategory)
      return {
        id: project.id,
        title: project.title.rendered,
        image: imageUrls[idx] || DEFAULT_IMAGE,
        category
      }
    })

    console.log('Proyectos mapeados:', projects.value)
    
    console.log('Proyectos cargados:', projects.value)
    
  } catch (error) {
    console.error('Error al cargar proyectos:', error)
  } finally {
    isLoading.value = false
  }
})
</script>

<style scoped>
section {
  background-color: #f9f9f9;
}
</style>
