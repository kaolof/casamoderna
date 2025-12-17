<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    required: true,
    default: () => []
  },
  altPrefix: {
    type: String,
    default: 'Imagen'
  }
})

const showModal = ref(false)
const currentImageIndex = ref(0)

const openModal = (index) => {
  currentImageIndex.value = index
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  showModal.value = false
  document.body.style.overflow = 'auto'
}

const nextImage = () => {
  if (currentImageIndex.value < props.images.length - 1) {
    currentImageIndex.value++
  }
}

const prevImage = () => {
  if (currentImageIndex.value > 0) {
    currentImageIndex.value--
  }
}

// Cerrar modal con la tecla Escape
const handleEscape = (e) => {
  if (e.key === 'Escape' && showModal.value) {
    closeModal()
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleEscape)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleEscape)
  // Limpiar overflow si el componente se desmonta con el modal abierto
  if (showModal.value) {
    document.body.style.overflow = 'auto'
  }
})
</script>

<template>
  <!-- Gallery Grid -->
  <section class="max-w-7xl mx-auto px-6 py-16">
    <div v-if="images && images.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div 
        v-for="(img, index) in images" 
        :key="index" 
        class="w-full cursor-pointer group relative overflow-hidden"
        @click="openModal(index)"
      >
        <img
          :src="img"
          :alt="`${altPrefix} - Imagen ${index + 1}`"
          class="w-full h-64 object-cover transition-all duration-300 group-hover:scale-110 group-hover:brightness-75"
        />
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
          </svg>
        </div>
      </div>
    </div>
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="i in 6" :key="i" class="w-full">
        <img
          src="https://via.placeholder.com/300x200.png?text=proyecto"
          alt="Proyecto galería"
          class="w-full h-64 object-cover"
        />
      </div>
    </div>
  </section>

  <!-- Modal de Imagen -->
  <Transition name="modal">
    <div 
      v-if="showModal" 
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
      @click.self="closeModal"
    >
      <!-- Botón cerrar -->
      <button
        @click="closeModal"
        class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10"
        aria-label="Cerrar"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Flecha izquierda -->
      <button
        v-if="currentImageIndex > 0"
        @click="prevImage"
        class="absolute left-4 text-white hover:text-gray-300 transition-colors p-2"
        aria-label="Imagen anterior"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <!-- Imagen -->
      <div class="max-w-7xl max-h-[90vh] px-16">
        <img
          :src="images[currentImageIndex]"
          :alt="`${altPrefix} - Imagen ${currentImageIndex + 1}`"
          class="max-w-full max-h-[90vh] object-contain"
        />
        <!-- Contador de imágenes -->
        <p class="text-white text-center mt-4">
          {{ currentImageIndex + 1 }} / {{ images.length }}
        </p>
      </div>

      <!-- Flecha derecha -->
      <button
        v-if="currentImageIndex < images.length - 1"
        @click="nextImage"
        class="absolute right-4 text-white hover:text-gray-300 transition-colors p-2"
        aria-label="Imagen siguiente"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </Transition>
</template>

<style scoped>
/* Animación del modal */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
