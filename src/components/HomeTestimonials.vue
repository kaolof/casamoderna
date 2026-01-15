<template>
  <section id="testimonials" class="w-full bg-gray-100 py-20">
    <div class="max-w-6xl mx-auto px-6">
      <!-- Header -->
      <div class="text-center mb-12 px-4 sm:px-0">
        <p class="text-gray-500 text-sm tracking-widest mb-4 uppercase">LO QUE DICEN NUESTROS CLIENTES</p>
        <h2 class="text-3xl md:text-5xl font-extrabold text-black leading-tight">
          La mejor garantía de <br class="hidden md:inline">nuestro trabajo</h2>
      </div>

      <!-- Category filters -->
      <div class="flex justify-center gap-4 mb-8">
        <button
          v-for="(cat, idx) in categories"
          :key="`cat-${idx}`"
          @click="selectCategory(cat)"
          :class="[cat === selectedCategory ? 'bg-orange-500 text-white' : 'bg-white text-gray-700 border', 'px-4 py-2 font-semibold transition']"
        >
          {{ cat }}
        </button>
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

        <!-- Arrows removed: navigation uses bottom dots -->

        <!-- Dots Navigation -->
        <div class="flex justify-center gap-3 mt-8" v-if="filteredTestimonials.length > 1">
          <button
            v-for="(_, index) in Math.ceil(filteredTestimonials.length / 2)"
            :key="`dot-${index}`"
            @click="goToPair(index)"
            class="transition-all duration-300"
            :class="index === Math.floor(currentIndex / 2) ? 'w-10 h-3 bg-orange-500 rounded-full' : 'w-3 h-3 bg-gray-300 rounded-full hover:bg-gray-400'"
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
// Only two categories as requested
const CATEGORY_TESTIMONIOS = 'TESTIMONIOS'
const CATEGORY_RNC = 'CALIFICACIÓN (RNC)'
const categories = [CATEGORY_TESTIMONIOS, CATEGORY_RNC]
const selectedCategory = ref(CATEGORY_TESTIMONIOS)

const getCategoryOf = (item) => {
  const acfCat = (item.acf?.categoria || '').toString().toLowerCase()
  // If ACF explicitly sets category, prefer that value
  if (acfCat) {
    if (acfCat.includes('rnc') || acfCat.includes('calif')) return CATEGORY_RNC
    if (acfCat.includes('test')) return CATEGORY_TESTIMONIOS
  }

  // Fallback heuristics: check tipo or presence of calificacion
  const tipo = (item.acf?.tipo || '').toString().toLowerCase()
  if (tipo.includes('rnc') || tipo.includes('calif') || item.acf?.calificacion) return CATEGORY_RNC
  return CATEGORY_TESTIMONIOS
}

// Testimonials filtered by selected category (using heuristics)
const filteredTestimonials = computed(() => {
  if (!testimonials.value || testimonials.value.length === 0) return []
  return testimonials.value.filter(item => getCategoryOf(item) === selectedCategory.value)
})

// Fetch testimonials from WordPress API
const fetchTestimonials = async () => {
  try {
    loading.value = true
    const apiBaseUrl = `https://${import.meta.env.VITE_WP_DOMAIN}/wp-json/wp/v2`
    const response = await fetch(`${apiBaseUrl}/testimonio`)
    if (!response.ok) throw new Error('Failed to fetch testimonials')
    
    const data = await response.json()
    
    // Map WordPress API structure to component structure (keep ACF for categorization)
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
        rating: parseInt(item.acf?.calificacion) || 5,
        acf: item.acf || {},
        _raw: item
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
  const list = filteredTestimonials.value
  if (list.length === 0) return []
  const a = list[currentIndex.value % list.length]
  if (list.length === 1) return [a]
  const b = list[(currentIndex.value + 1) % list.length]
  return [a, b]
})

let timer = null
const startAutoplay = () => {
  stopAutoplay()
  const len = filteredTestimonials.value.length
  if (len <= 1) return
  timer = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % len
  }, 5000)
}

const stopAutoplay = () => {
  if (timer) {
    clearInterval(timer)
    timer = null
  }
}


const goToPair = (index) => {
  const len = filteredTestimonials.value.length
  if (len === 0) return
  currentIndex.value = (index * 2) % len
  startAutoplay()
}

// `next`/`prev` removed — navigation handled via dots and autoplay

const selectCategory = (cat) => {
  selectedCategory.value = cat
  currentIndex.value = 0
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
