<script setup>
import { ref, onMounted } from 'vue'
import HomeNavbar from '../components/HomeNavbar.vue'
import HomeContactFooter from '../components/HomeContactFooter.vue'
import ImageGallery from '../components/ImageGallery.vue'

const props = defineProps({
  id: {
    type: String,
    required: true
  }
})

const project = ref({
  category: 'PROYECTO',
  name: '',
  heroImage: '/images/portfolioHero.png',
  client: 'Nombre del cliente',
  year: '',
  location: 'LOCDEMÍA',
  area: '2085 M2',
  services: '8',
  description: '',
  descriptionContinued: '',
  galleryImages: []
})

const isLoading = ref(true)
const relatedProjects = ref([])

// Helper function para cargar imágenes en paralelo
const fetchImageUrl = async (imageId, defaultUrl = '/images/portfolioHero.png') => {
  if (!imageId) return defaultUrl
  try {
    const response = await fetch(`https://cms.construcasamoderna.com/wp-json/wp/v2/media/${imageId}`)
    const data = await response.json()
    return data.source_url || defaultUrl
  } catch (error) {
    console.error(`Error al cargar imagen ${imageId}:`, error)
    return defaultUrl
  }
}

// Cargar proyecto desde la API
onMounted(async () => {
  try {
    // Obtener datos del proyecto y proyectos relacionados en paralelo
    const [projectData, projectsData] = await Promise.all([
      fetch(`https://cms.construcasamoderna.com/wp-json/wp/v2/proyecto/${props.id}`).then(r => r.json()),
      fetch('https://cms.construcasamoderna.com/wp-json/wp/v2/proyecto').then(r => r.json())
    ])
    
    console.log('Project data from API:', projectData)
    
    // Recolectar todos los IDs de imágenes que necesitamos cargar
    const imageIds = []
    
    // Imagen principal
    const mainImageId = projectData.acf?.['image-main']
    if (mainImageId) imageIds.push(mainImageId)
    
    // Imágenes de galería
    const imagenesDetalle = projectData.acf?.['imagen-detalle']
    const galleryImageIds = []
    if (imagenesDetalle) {
      for (let i = 1; i <= 9; i++) {
        const imgId = imagenesDetalle[`image${i}`]
        if (imgId) {
          galleryImageIds.push(imgId)
          imageIds.push(imgId)
        }
      }
    }
    
    // Imágenes de proyectos relacionados
    const relatedProjectsData = projectsData
      .filter(p => p.id !== parseInt(props.id))
      .slice(0, 3)
    
    const relatedImageIds = relatedProjectsData
      .map(p => p.acf?.['image-main'])
      .filter(Boolean)
    
    imageIds.push(...relatedImageIds)
    
    // Cargar TODAS las imágenes en paralelo
    const imageUrls = await Promise.all(
      imageIds.map(id => fetchImageUrl(id))
    )
    
    // Mapear las URLs a sus respectivos usos
    let imageIndex = 0
    const heroImage = mainImageId ? imageUrls[imageIndex++] : '/images/portfolioHero.png'
    const galleryImages = galleryImageIds.map(() => imageUrls[imageIndex++])
    
    // Actualizar proyecto con datos básicos primero (renderizado más rápido)
    project.value = {
      category: 'PROYECTO',
      name: projectData.title.rendered,
      heroImage: heroImage,
      client: projectData.acf?.['nombre-cliente'] || 'Nombre del cliente',
      year: projectData.acf?.['year-proyecto'] || '',
      location: projectData.acf?.['ubicacion'] || 'LOCDEMÍA',
      area: projectData.acf?.['area'] || '2085 M2',
      structure: projectData.acf?.['estructura'] || null,
      bedrooms: projectData.acf?.['habitaciones'] || null,
      bathrooms: projectData.acf?.['banos'] || null,
      description: projectData.acf?.['description'] || '',
      descriptionContinued: projectData.acf?.['descripcion-extendida'] || '',
      galleryImages: galleryImages
    }
    
    // Mapear proyectos relacionados con sus imágenes
    relatedProjects.value = relatedProjectsData.map((p, idx) => {
      const imgId = p.acf?.['image-main']
      const image = imgId ? imageUrls[imageIndex++] : '/images/portfolioHero.png'
      return {
        id: p.id,
        name: p.title.rendered,
        image: image
      }
    })
    
  } catch (error) {
    console.error('Error al cargar el proyecto:', error)
  } finally {
    isLoading.value = false
  }
})
</script>

<template>
  <!-- Navbar -->
  <HomeNavbar />

  <!-- Loading State -->
  <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
    <div class="text-center">
      <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-orange-500 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
        <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Cargando...</span>
      </div>
      <p class="mt-4 text-gray-600 font-medium">Cargando proyecto...</p>
    </div>
  </div>

  <!-- Project Content -->
  <div v-else>
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
  <ImageGallery 
    :images="project.galleryImages" 
    :alt-prefix="project.name"
  />

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
        <router-link
          v-for="proj in relatedProjects"
          :key="proj.id"
          :to="{ name: 'project-detail', params: { id: proj.id } }"
          class="relative group overflow-hidden rounded cursor-pointer"
        >
          <img
            :src="proj.image"
            alt="Proyecto relacionado"
            class="w-full h-64 object-cover group-hover:opacity-80 transition-opacity"
          />
          <div class="absolute inset-0 bg-opacity-40 flex flex-col justify-end p-6 text-white">
            <h3 class="font-bold">{{ proj.name }}</h3>
          </div>
        </router-link>
      </div>
    </section>

    <!-- Contact Section (reutilizando homeContactFooter) -->
    <HomeContactFooter />
  </div>
</template>
