<template>
  <div id="contact" class="w-full">
    <!-- Contact Section with Form -->
    <div class="relative w-full md:h-[560px] h-auto bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&h=500&fit=crop')">
      <!-- Overlay oscuro -->
      <div class="absolute inset-0 bg-black/50"></div>

      <div class="relative h-full flex items-start py-8 md:py-16">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-8 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-start">
          <!-- Left Side - Contact Info -->
          <div class="text-white w-full">
            <h2 class="text-4xl font-bold mb-4">¿Listo para dar el siguiente paso?</h2>
            <p class="text-gray-200 mb-8">Ya sea que estés planeando tu nuevo hogar, un espacio comercial o un proyecto de gran escala, estamos aquí para ayudarte a materializarlo.</p>
            
            <div class="space-y-3 flex flex-col items-center md:items-start">
              <div class="flex items-center gap-3 justify-center md:justify-start">
                <Phone class="h-5 w-5 text-orange-500" />
                <a href="tel:+58000000000" class="text-orange-500 font-semibold">+58 000 000 0000</a>
              </div>
              <div class="flex items-center gap-3 justify-center md:justify-start">
                <Mail class="h-5 w-5 text-orange-500" />
                <a href="mailto:info@construcasaomodern.com" class="text-white">Info@construcasaomodern.com</a>
              </div>
              <div class="flex items-center gap-3 justify-center md:justify-start">
                <MapPin class="h-5 w-5 text-orange-500" />
                <span class="text-white">Dirección</span>
              </div>
            </div>
          </div>
          
          <!-- Right Side - Contact Form -->
          <div class="w-full max-w-xl">
            <form @submit.prevent="handleSubmit" class="space-y-4">
              <input
                v-model="form.name"
                type="text"
                placeholder="Nombre y apellido"
                class="w-full bg-white px-4 py-3 border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                required
              />
              <input
                v-model="form.email"
                type="email"
                placeholder="Email"
                class="w-full bg-white px-4 py-3 border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                required
              />
              <input
                v-model="form.phone"
                type="tel"
                placeholder="Número de teléfono"
                class="w-full bg-white px-4 py-3 border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                required
              />
              <textarea
                v-model="form.message"
                placeholder="Texto"
                rows="6"
                class="w-full bg-white px-4 py-3 border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none h-40"
                required
              ></textarea>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full px-12 py-4 border-2 border-white text-white font-bold tracking-widest hover:bg-white hover:text-black transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ isSubmitting ? 'ENVIANDO...' : 'ENVIAR' }}
              </button>
            </form>

            <!-- Mensajes de éxito/error -->
            <div v-if="statusMessage.text" class="mt-4 p-4 rounded" :class="{
              'bg-green-100 border border-green-400 text-green-700': statusMessage.type === 'success',
              'bg-red-100 border border-red-400 text-red-700': statusMessage.type === 'error'
            }">
              <p class="font-semibold">{{ statusMessage.text }}</p>
              <ul v-if="statusMessage.errors && statusMessage.errors.length" class="mt-2 list-disc list-inside text-sm">
                <li v-for="(error, index) in statusMessage.errors" :key="index">{{ error }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Info Section -->
    <div class="bg-[#D1DEDE] py-6 px-4 sm:px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Logo Placeholder (temporary div) -->
        <div class="flex items-center justify-center md:justify-start w-full md:w-1/2">
          <div class="w-48 h-20 flex items-center justify-center">
            <img src="/images/logo.png" alt="CONSTRUSERVICIOS logo" class="w-full h-auto object-contain" />
          </div>
        </div>

        <!-- Contact Info -->
        <div class="w-full md:w-1/2 text-center md:text-right space-y-2">
          <div class="flex items-center justify-center md:justify-end gap-2 text-gray-700">
            <Phone class="h-5 w-5 text-orange-500" />
            <span>+58 000 000 0000</span>
          </div>
          <div class="flex items-center justify-center md:justify-end gap-2 text-gray-700">
            <Mail class="h-5 w-5 text-orange-500" />
            <span>info@construcasaomodern.com</span>
          </div>
          <div class="flex items-center justify-center md:justify-end gap-2 text-gray-700">
            <MapPin class="h-5 w-5 text-orange-500" />
            <span>Dirección</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="bg-black text-white py-6 px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-400 text-center md:text-left">© CONSTRUSERVICIOS CASAMODERNA. Todos los derechos reservados.</p>
        <p class="text-sm text-gray-400 text-center md:text-right">Desarrollado por Tkwebspace</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Phone, Mail, MapPin } from 'lucide-vue-next'

// Estado del formulario
const form = ref({
  name: '',
  email: '',
  phone: '',
  message: ''
})

// Estado de envío y mensajes
const isSubmitting = ref(false)
const statusMessage = ref({
  text: '',
  type: '', // 'success' o 'error'
  errors: []
})

/**
 * Maneja el envío del formulario de contacto
 * Envía los datos a contact.php usando fetch con application/x-www-form-urlencoded
 */
const handleSubmit = async () => {
  // Limpiar mensajes anteriores
  statusMessage.value = { text: '', type: '', errors: [] }
  isSubmitting.value = true

  try {
    // Preparar los datos en formato application/x-www-form-urlencoded
    const formData = new URLSearchParams()
    formData.append('name', form.value.name)
    formData.append('email', form.value.email)
    formData.append('phone', form.value.phone)
    formData.append('message', form.value.message)

    // Determinar la URL del endpoint según el entorno
    // En desarrollo (npm run dev): usar la ruta del servidor de desarrollo
    // En producción (después del build): usar la ruta relativa al dominio
    const endpoint = import.meta.env.DEV 
      ? '/contact.php'  // Vite proxy o servidor de desarrollo
      : '/contact.php'  // En producción, el archivo estará en la raíz junto a index.html

    // Enviar la solicitud POST
    const response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: formData.toString()
    })

    // Procesar la respuesta JSON
    const data = await response.json()

    if (data.success) {
      // Éxito: mostrar mensaje de confirmación
      statusMessage.value = {
        text: data.message,
        type: 'success',
        errors: []
      }

      // Limpiar el formulario después de un envío exitoso
      form.value = {
        name: '',
        email: '',
        phone: '',
        message: ''
      }

      // Ocultar el mensaje de éxito después de 8 segundos
      setTimeout(() => {
        if (statusMessage.value.type === 'success') {
          statusMessage.value = { text: '', type: '', errors: [] }
        }
      }, 8000)

    } else {
      // Error: mostrar mensaje de error y posibles validaciones
      statusMessage.value = {
        text: data.message || 'Hubo un error al enviar el formulario.',
        type: 'error',
        errors: data.errors || []
      }
    }

  } catch (error) {
    // Error de red o del servidor
    console.error('Error al enviar el formulario:', error)
    statusMessage.value = {
      text: 'Error de conexión. Por favor, verifica tu conexión a internet e intenta nuevamente.',
      type: 'error',
      errors: []
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
input:focus, textarea:focus {
  box-shadow: none;
}
</style>
