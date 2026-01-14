<template>
  <section id="testimonials" class="w-full bg-gray-100 py-20">
    <div class="max-w-6xl mx-auto px-6">
      <!-- Header -->
      <div class="text-center mb-12 px-4 sm:px-0">
        <p class="text-gray-500 text-sm tracking-widest mb-4 uppercase">EVALUACIÓN DE DESEMPEÑO</p>
        <h2 class="text-3xl md:text-5xl font-extrabold text-black leading-tight">Calificación certificada por el<br class="hidden md:inline">Registro Nacional de Contratistas</h2>
      </div>

      <!-- Testimonials Slider (two cards visible) -->
      <div class="relative">
        <transition name="fade" mode="out-in">
          <div :key="`pair-${currentIndex}`" :class="['grid gap-8 items-start', visiblePair.length > 1 ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-1 md:grid-cols-1']">
            <div v-for="(t, i) in visiblePair" :key="`card-${currentIndex}-${i}`" :class="['bg-white p-8 shadow-sm', visiblePair.length === 1 ? 'mx-auto md:w-1/2' : '']">
              <div class="flex items-start">
                <img :src="t.avatar" :alt="t.name" class="w-20 h-20 rounded-full object-cover mr-6 border-4 border-white shadow-md" />
                <div class="flex-1">
                  <h4 class="text-black font-semibold text-lg">{{ t.name }}</h4>
                  <p class="text-gray-500 italic mt-2 text-sm">"{{ t.comment }}"</p>
                  <div class="mt-4 flex items-center">
                    <template v-for="j in 5">
                      <svg v-if="j <= t.rating" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" :key="`star-${currentIndex}-${i}-${j}`">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.383 2.455a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.383-2.455a1 1 0 00-1.176 0l-3.383 2.455c-.784.57-1.84-.197-1.54-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z" />
                      </svg>
                      <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" viewBox="0 0 20 20" fill="currentColor" :key="`star-empty-${currentIndex}-${i}-${j}`">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.383 2.455a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.383-2.455a1 1 0 00-1.176 0l-3.383 2.455c-.784.57-1.84-.197-1.54-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z" />
                      </svg>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>

        <!-- Dots Navigation -->
        <div class="flex justify-center gap-3 mt-8" v-if="testimonials.length > 1">
          <button
            v-for="(_, index) in Math.ceil(testimonials.length / 2)"
            :key="`dot-${index}`"
            @click="goToPair(index)"
            class="transition-all duration-300"
            :class="index * 2 === currentIndex ? 'w-10 h-3 bg-orange-500 rounded-full' : 'w-3 h-3 bg-gray-300 rounded-full hover:bg-gray-400'"
            :aria-label="`Go to testimonial ${index + 1}`"
          />
        </div>
        
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-8">
          <p class="text-gray-500">Cargando testimonios...</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const testimonials = ref([])
const loading = ref(true)
const error = ref(null)

// Fetch testimonials from WordPress API
const fetchTestimonials = async () => {
  try {
    loading.value = true
    const apiBaseUrl = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`
    const response = await fetch(`${apiBaseUrl}/testimonio`)
    if (!response.ok) throw new Error('Failed to fetch testimonials')
    
    const data = await response.json()
    
    // Map WordPress API structure to component structure
    testimonials.value = await Promise.all(data.map(async (item) => {
      let avatarUrl = '/images/testimonios/default.jpg' // fallback
      
      // Fetch avatar image if available
      if (item.acf?.avatar) {
        try {
          const mediaResponse = await fetch(`${apiBaseUrl}/media/${item.acf.avatar}`)
          if (mediaResponse.ok) {
            const mediaData = await mediaResponse.json()
            avatarUrl = mediaData.source_url || avatarUrl
          }
        } catch (err) {
          console.warn('Failed to fetch avatar:', err)
        }
      }
      
      return {
        avatar: avatarUrl,
        name: item.title?.rendered || 'Sin nombre',
        comment: item.acf?.comentario || 'Muy Bueno',
        rating: parseInt(item.acf?.calificacion) || 5
      }
    }))
  } catch (err) {
    console.error('Error fetching testimonials:', err)
    error.value = err.message
    // Fallback data
    testimonials.value = [
      {
        avatar: '/images/testimonios/metor.jpg',
        name: 'Metanol de Oriente, Metor S.A',
        comment: 'Muy Bueno',
        rating: 4
      }
    ]
  } finally {
    loading.value = false
  }
}

const currentIndex = ref(0)

const visiblePair = computed(() => {
  if (testimonials.value.length === 0) return []
  const a = testimonials.value[currentIndex.value % testimonials.value.length]
  if (testimonials.value.length === 1) return [a]
  const b = testimonials.value[(currentIndex.value + 1) % testimonials.value.length]
  // avoid duplicating the same object when length===1
  return [a, b]
})

let timer = null
const startAutoplay = () => {
  stopAutoplay()
  if (testimonials.value.length <= 1) return
  timer = setInterval(() => {
    currentIndex.value = (currentIndex.value + 2) % testimonials.value.length
  }, 5000)
}

const stopAutoplay = () => {
  if (timer) {
    clearInterval(timer)
    timer = null
  }
}

const goToPair = (index) => {
  currentIndex.value = (index * 2) % testimonials.value.length
  startAutoplay()
}

onMounted(async () => {
  await fetchTestimonials()
  startAutoplay()
})
onBeforeUnmount(() => stopAutoplay())
</script>

<style scoped>
.star-filled { color: #FBBF24; }
.star-empty { color: #E5E7EB; }

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.6s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}
</style>
