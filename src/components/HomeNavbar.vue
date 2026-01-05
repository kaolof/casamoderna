<template>
  <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex items-center justify-between gap-4">
        <!-- Logo -->
        <router-link to="/" class="flex flex-col sm:flex-row sm:items-center sm:gap-2 text-gray-900 cursor-pointer hover:opacity-80 transition-opacity">
          <span class="text-xs sm:text-sm font-light italic text-gray-600">CONSTRUSERVICIOS</span>
          <span class="text-lg font-bold tracking-wide">CASA MODERNA</span>
        </router-link>

        <button
          type="button"
          class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100"
          @click="toggleMenu"
          aria-label="Abrir menú"
        >
          <svg v-if="!isMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Desktop Navigation Links -->
        <div class="hidden md:flex items-center gap-8">
          <template v-for="link in navLinks" :key="link.name">
            <router-link
              v-if="!link.href.startsWith('#')"
              :to="link.href"
              class="text-sm font-medium transition-all cursor-pointer pb-1 text-gray-800 hover:text-orange-500 border-b-2 border-transparent hover:border-orange-500"
            >
              {{ link.name }}
            </router-link>

            <a
              v-else
              :href="link.href"
              class="text-sm font-medium transition-all cursor-pointer pb-1 text-gray-800 hover:text-orange-500 border-b-2 border-transparent hover:border-orange-500"
            >
              {{ link.name }}
            </a>
          </template>
        </div>
      </div>

      <!-- Mobile Navigation Links -->
      <transition name="fade">
        <div
          v-if="isMenuOpen"
          class="md:hidden mt-4 border-t border-gray-200 pt-4 flex flex-col gap-3 text-sm"
        >
          <template v-for="link in navLinks" :key="`mobile-${link.name}`">
            <router-link
              v-if="!link.href.startsWith('#')"
              :to="link.href"
              class="py-2 text-gray-800 font-medium border-b border-gray-100 last:border-b-0 hover:text-orange-500"
              @click="closeMenu"
            >
              {{ link.name }}
            </router-link>

            <a
              v-else
              :href="link.href"
              class="py-2 text-gray-800 font-medium border-b border-gray-100 last:border-b-0 hover:text-orange-500"
              @click="closeMenu"
            >
              {{ link.name }}
            </a>
          </template>
        </div>
      </transition>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

const isMenuOpen = ref(false)

const navLinks = [
  { name: 'Home', href: '/' },
  { name: 'Nosotros', href: '#about' },
  { name: 'Proyectos', href: '/proyectos' },
  { name: 'Servicios', href: '#services' },
  { name: 'Testimonios', href: '#testimonials' },
  { name: 'Contacto', href: '#contact' }
]

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}
</script>

<style scoped>
nav {
  background-color: #ffffff;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>