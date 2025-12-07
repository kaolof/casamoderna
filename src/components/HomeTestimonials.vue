<template>
  <section id="testimonials" class="w-full bg-gray-100 py-18">
    <div class="max-w-6xl mx-auto px-6">
      <!-- Header -->
      <div class="text-center mb-12 px-4 sm:px-0">
        <p class="text-gray-500 text-sm tracking-widest mb-4">LO QUE DICEN NUESTROS CLIENTES</p>
        <h2 class="text-2xl md:text-5xl font-bold text-black">La mejor garantía de nuestro trabajo</h2>
      </div>

      <!-- Testimonials Carousel -->
      <div class="relative">
        <div class="overflow-hidden">
          <transition-group
            name="fade"
            tag="div"
            class="w-full"
          >
            <div
              v-for="(testimonial, index) in testimonials"
              v-show="index === currentTestimonial"
              :key="`testimonial-${index}`"
              class="w-full flex-shrink-0"
            >
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-lg">
                  <div class="flex items-center mb-6">
                    <img
                      :src="testimonial.avatar"
                      :alt="testimonial.name"
                      class="w-16 h-16 rounded-full object-cover mr-4"
                    />
                    <div>
                      <h4 class="font-bold text-black">{{ testimonial.name }}</h4>
                      <p class="text-orange-500 text-sm font-semibold">{{ testimonial.project }}</p>
                    </div>
                  </div>
                  <p class="text-gray-600 text-sm leading-relaxed">{{ testimonial.text }}</p>
                </div>

                <!-- Testimonial 2 (if exists) -->
                <div
                  v-if="index + 1 < testimonials.length"
                  class="bg-white p-8 rounded-lg"
                >
                  <div class="flex items-center mb-6">
                    <img
                      :src="testimonials[index + 1].avatar"
                      :alt="testimonials[index + 1].name"
                      class="w-16 h-16 rounded-full object-cover mr-4"
                    />
                    <div>
                      <h4 class="font-bold text-black">{{ testimonials[index + 1].name }}</h4>
                      <p class="text-orange-500 text-sm font-semibold">{{ testimonials[index + 1].project }}</p>
                    </div>
                  </div>
                  <p class="text-gray-600 text-sm leading-relaxed">{{ testimonials[index + 1].text }}</p>
                </div>
              </div>
            </div>
          </transition-group>
        </div>

        <!-- Dots Navigation -->
        <div class="flex justify-center gap-3 mt-12">
          <button
            v-for="(_, index) in Math.ceil(testimonials.length / 2)"
            :key="`dot-${index}`"
            @click="currentTestimonial = index * 2"
            class="transition-all duration-300"
            :class="
              index * 2 === currentTestimonial
                ? 'w-8 h-3 bg-orange-500 rounded-full'
                : 'w-3 h-3 bg-gray-300 rounded-full hover:bg-gray-400'
            "
            :aria-label="`Go to testimonial ${index + 1}`"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const currentTestimonial = ref(0)

const testimonials = [
  {
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
    name: 'Nombre del cliente',
    project: 'NOMBRE DEL PROYECTO',
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim eros ac scelerisque ante pulvinar.'
  },
  {
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    name: 'Nombre del cliente',
    project: 'NOMBRE DEL PROYECTO',
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim eros ac scelerisque ante pulvinar.'
  },
  {
    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop',
    name: 'Nombre del cliente',
    project: 'NOMBRE DEL PROYECTO',
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim eros ac scelerisque ante pulvinar.'
  },
  {
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    name: 'Nombre del cliente',
    project: 'NOMBRE DEL PROYECTO',
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim eros ac scelerisque ante pulvinar.'
  }
]
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s ease;
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
