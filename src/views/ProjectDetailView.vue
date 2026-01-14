<script setup>
import { ref, onMounted } from 'vue'
import HomeNavbar from '../components/HomeNavbar.vue'
import HomeContactFooter from '../components/HomeContactFooter.vue'
import ImageGallery from '../components/ImageGallery.vue'

const API_BASE_URL = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`

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
  technicalData: {
    area: '',
    constructionSystem: '',
    levels: '',
    mainInstallations: ''
  },
  developedServices: [],
  projectStatus: '',
  galleryImages: []
})

const isLoading = ref(true)
const relatedProjects = ref([])

// Datos de prueba
const mockProject = {
  category: 'PROYECTO',
  name: 'Casa Moderna Residencial',
  heroImage: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200&q=80',
  client: 'Familia López',
  year: '2024',
  location: 'Ciudad de México',
  area: '350 M2',
  services: 'Construcción completa, diseño arquitectónico, diseño de interiores',
  description: 'Este proyecto representa la perfecta fusión entre diseño contemporáneo y funcionalidad. La Casa Moderna Residencial fue diseñada para una familia joven que buscaba un espacio luminoso, amplio y conectado con el exterior.',
  descriptionContinued: 'Se utilizaron materiales de primera calidad incluyendo concreto aparente, madera de nogal y grandes ventanales de piso a techo. El diseño incorpora conceptos de eficiencia energética y sustentabilidad, con paneles solares y sistemas de captación de agua pluvial.',
  technicalData: {
    area: '350 m²',
    constructionSystem: 'Estructura de concreto armado con muros de block',
    levels: '2 niveles',
    mainInstallations: 'Eléctrica (220V trifásica), sanitaria (agua potable y drenaje), mecánica (climatización central con tecnología inverter), instalación solar (paneles fotovoltaicos 5kW)'
  },
  developedServices: ['Arquitectura', 'Ingeniería', 'Ejecución de obra', 'Supervisión', 'Gestión integral'],
  projectStatus: 'Ejecutado',
  galleryImages: [
    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80',
    'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=800&q=80',
    'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&q=80'
  ]
}

const mockRelatedProjects = [
  {
    id: 2,
    name: 'Villa Contemporánea',
    image: 'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800&q=80'
  },
  {
    id: 3,
    name: 'Residencia Minimalista',
    image: 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=800&q=80'
  },
  {
    id: 4,
    name: 'Casa Jardín',
    image: 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=800&q=80'
  }
]

// Helper function para cargar imágenes en paralelo
const fetchImageUrl = async (imageId, defaultUrl = '/images/portfolioHero.png') => {
  if (!imageId) return defaultUrl
  try {
    const response = await fetch(`${API_BASE_URL}/media/${imageId}`)
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
      fetch(`${API_BASE_URL}/proyecto/${props.id}`).then(r => r.json()),
      fetch(`${API_BASE_URL}/proyecto`).then(r => r.json())
    ])
    
    // Recolectar todos los IDs de imágenes que necesitamos cargar
    const imageIds = []
    
    // Imagen principal (usar la primera imagen disponible del objeto imagenes)
    const imagenesObj = projectData.acf?.imagenes
    const galleryImageIds = []
    let mainImageId = null
    
    if (imagenesObj) {
      // Recolectar todas las imágenes del objeto imagenes (imagen1 a imagen9)
      for (let i = 1; i <= 9; i++) {
        const imgId = imagenesObj[`imagen${i}`]
        if (imgId) {
          galleryImageIds.push(imgId)
          imageIds.push(imgId)
          // La primera imagen será la imagen principal del hero
          if (!mainImageId) mainImageId = imgId
        }
      }
    }
    
    // Imágenes de proyectos relacionados: extraer la "imagen principal" buscando
    // primero en `acf.imagenes` (imagen1..imagen9) y si no existe, en `acf['image-main']`.
    const relatedProjectsData = projectsData
      .filter(p => p.id !== parseInt(props.id))
      .slice(0, 3)

    // Guardamos el id principal por proyecto (puede ser null)
    const relatedMainIdsByProject = relatedProjectsData.map(p => {
      let rMain = null
      const imgs = p.acf?.imagenes
      if (imgs) {
        for (let j = 1; j <= 9; j++) {
          const id = imgs[`imagen${j}`]
          if (id) { rMain = id; break }
        }
      }
      if (!rMain) rMain = p.acf?.['image-main'] || null
      return rMain
    })

    // IDs de imágenes relacionadas (solo los que existan)
    const relatedImageIds = relatedMainIdsByProject.filter(Boolean)
    imageIds.push(...relatedImageIds)

    // Cargar TODAS las imágenes en paralelo
    const imageUrls = await Promise.all(imageIds.map(id => fetchImageUrl(id)))

    // Crear mapa id -> url para asignar imágenes de forma segura
    const imageUrlMap = {}
    imageIds.forEach((id, i) => {
      imageUrlMap[id] = imageUrls[i]
    })

    // Mapear las URLs a sus respectivos usos
    const heroImage = mainImageId ? imageUrlMap[mainImageId] || '/images/portfolioHero.png' : '/images/portfolioHero.png' // La primera imagen es la portada
    const galleryImages = galleryImageIds.map(id => imageUrlMap[id] || '/images/portfolioHero.png') // Incluir todas las imágenes (incluida la primera)

    // Actualizar proyecto con datos básicos primero (renderizado más rápido)
    project.value = {
      category: projectData.acf?.categoria || 'PROYECTO',
      name: projectData.title.rendered,
      heroImage: heroImage,
      client: projectData.acf?.ficha_tecnica?.cliente || "-",
      year: projectData.acf?.ficha_tecnica?.year || '-',
      location: projectData.acf?.ficha_tecnica?.ubicacion || '-',
      area: projectData.acf?.datos_tecnicos?.area ? `${projectData.acf.datos_tecnicos.area} M²` : '-',
      description: projectData.acf?.descripcion || '-',
      technicalData: {
        area: projectData.acf?.datos_tecnicos?.area ? `${projectData.acf.datos_tecnicos.area} m²` : '-',
        constructionSystem: projectData.acf?.datos_tecnicos?.sistema_constructivo || '-',
        levels: projectData.acf?.datos_tecnicos?.niveles || '-',
        mainInstallations: projectData.acf?.datos_tecnicos?.principales_instalaciones || '-'
      },
      developedServices: Array.isArray(projectData.acf?.servicios_desarrollados) 
        ? projectData.acf.servicios_desarrollados 
        : [],
      projectStatus: projectData.acf?.estado_del_proyecto || '-',
      galleryImages: galleryImages
    }
    
    // Mapear proyectos relacionados con sus imágenes usando el mapa id->url
    relatedProjects.value = relatedProjectsData.map((p, idx) => {
      const rMainId = relatedMainIdsByProject[idx]
      const image = rMainId ? (imageUrlMap[rMainId] || '/images/portfolioHero.png') : '/images/portfolioHero.png'
      return {
        id: p.id,
        name: p.title.rendered,
        image: image
      }
    })
    
  } catch (error) {
    console.error('Error al cargar el proyecto:', error)
    // Si hay error, usar datos de prueba
    project.value = mockProject
    relatedProjects.value = mockRelatedProjects
  } finally {
    isLoading.value = false
    // Si después de todo no hay datos, usar mock
    if (!project.value.name || project.value.name === '') {
      project.value = mockProject
    }
    if (relatedProjects.value.length === 0) {
      relatedProjects.value = mockRelatedProjects
    }
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
  <section class="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-[100px_1fr_300px] gap-4 md:gap-8 items-start">
    <!-- Column 1: Title with vertical orange bar -->
    <div class="order-2 md:order-1 flex items-start py-4 md:py-10">
      <div class="w-3 md:w-4 h-8 md:h-20 bg-orange-500 mr-2 flex-shrink-0"></div>
      <div>
        <h2 class="text-sm font-bold">Acerca del proyecto</h2>
      </div>
    </div>

    <!-- Column 2: Long description -->
    <div class="order-3 md:order-2 py-4 md:py-10">
      <p class="text-gray-600 leading-relaxed mb-6">
        {{ project.description }}
      </p>
    </div>

    <!-- Column 3: Technical card (spans 4 rows) -->
    <aside class="order-1 md:order-3 p-4 md:p-8 h-fit border border-gray-200 md:row-span-4" style="background-color: rgba(209,222,222,0.3);">
      <div class="space-y-4">
        <div>
          <p class="text-xs text-gray-500 mb-1">Proyecto</p>
          <p class="font-bold text-sm">{{ project.name }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Tipo</p>
          <p class="font-bold text-sm">{{ project.category }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Ubicación</p>
          <p class="font-bold text-sm">{{ project.location }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Año</p>
          <p class="font-bold text-sm">{{ project.year }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500 mb-1">Cliente</p>
          <p class="font-bold text-sm">{{ project.client }}</p>
        </div>
      </div>
    </aside>

    <!-- Datos Técnicos Section - Row 2 -->
    <div class="order-4 md:order-4 flex items-start pb-4 md:pb-10">
      <div class="w-3 md:w-4 h-8 md:h-20 bg-orange-500 mr-2 flex-shrink-0"></div>
      <div>
        <h4 class="text-sm font-bold">Datos Técnicos</h4>
      </div>
    </div>

    <div class="order-5 md:order-5 pb-4 md:pb-10">
      <div class="text-gray-600 leading-relaxed space-y-2">
        <p><strong>Área:</strong> {{ project.technicalData.area }}</p>
        <p><strong>Sistema constructivo:</strong> {{ project.technicalData.constructionSystem }}</p>
        <p><strong>Niveles:</strong> {{ project.technicalData.levels }}</p>
        <p><strong>Principales instalaciones:</strong> {{ project.technicalData.mainInstallations }}</p>
      </div>
    </div>

    <!-- Servicios Desarrollados Section - Row 3 -->
    <div class="order-6 md:order-6 flex items-start pb-4 md:pb-10">
      <div class="w-3 md:w-4 h-8 md:h-20 bg-orange-500 mr-2 flex-shrink-0"></div>
      <div>
        <h4 class="text-sm font-bold">Servicios Desarrollados</h4>
      </div>
    </div>

    <div class="order-7 md:order-7 pb-4 md:pb-10">
      <p class="text-gray-600 leading-relaxed">
        <span class="text-gray-600">
          {{ Array.isArray(project.developedServices) ? project.developedServices.join(' · ') : project.developedServices }}
        </span>
      </p>
    </div>

    <!-- Estado del Proyecto Section - Row 4 -->
    <div class="order-8 md:order-8 flex items-start pb-4 md:pb-10">
      <div class="w-3 md:w-4 h-8 md:h-20 bg-orange-500 mr-2 flex-shrink-0"></div>
      <div>
        <h4 class="text-sm font-bold">Estado del Proyecto</h4>
      </div>
    </div>

    <div class="order-9 md:order-9 pb-4 md:pb-10">
      <p class="text-gray-600 font-bold">
        {{ project.projectStatus }}
      </p>
    </div>
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
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <router-link
          v-for="proj in relatedProjects"
          :key="proj.id"
          :to="{ name: 'project-detail', params: { id: proj.id } }"
          class="relative group overflow-hidden cursor-pointer border border-gray-100 shadow-sm hover:shadow-md transition-shadow"
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
