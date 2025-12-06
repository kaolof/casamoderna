<script setup>
const currentYear = new Date().getFullYear()
</script>

<template>
  <section id="contact" class="bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 grid gap-12 md:grid-cols-2">
      <div class="space-y-8">
        <div>
          <p class="uppercase text-xs tracking-[0.4em] text-gray-500 mb-4">Hablemos</p>
          <h2 class="text-3xl md:text-4xl font-semibold text-gray-900">¿Listo para el siguiente paso?</h2>
          <p class="text-gray-600 mt-4">
            Completa el formulario para agendar una reunión estratégica con nuestro equipo de arquitectos.
          </p>
        </div>
        <div class="space-y-4">
          <div class="flex gap-4">
            <span class="text-orange-500 text-xl">📍</span>
            <div>
              <p class="font-semibold text-gray-900">Showroom</p>
              <p class="text-gray-600">Calle Principal 123, Madrid</p>
            </div>
          </div>
          <div class="flex gap-4">
            <span class="text-orange-500 text-xl">📞</span>
            <div>
              <p class="font-semibold text-gray-900">Teléfono</p>
              <p class="text-gray-600">+34 900 123 456</p>
            </div>
          </div>
          <div class="flex gap-4">
            <span class="text-orange-500 text-xl">✉️</span>
            <div>
              <p class="font-semibold text-gray-900">Email</p>
              <p class="text-gray-600">hola@casamoderna.com</p>
            </div>
          </div>
        </div>
        <div class="rounded-3xl overflow-hidden shadow">
          <div class="bg-gray-100 h-48 flex items-center justify-center text-gray-500">
            Mapa en construcción
          </div>
        </div>
      </div>
      <div class="relative rounded-3xl overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center"
          style="background-image: url('https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=1200&h=800&fit=crop')"></div>
        <div class="absolute inset-0 bg-black/50"></div>
        <form class="relative z-10 m-6 bg-white/95 backdrop-blur p-8 rounded-2xl space-y-4" @submit.prevent>
          <p class="text-xs uppercase tracking-[0.4em] text-gray-500">Contacto</p>
          <h3 class="text-2xl font-semibold text-gray-900">Agenda una consultoría</h3>
          <input type="text" placeholder="Nombre" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500" />
          <input type="email" placeholder="Correo" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500" />
          <textarea rows="4" placeholder="Cuéntanos sobre tu proyecto" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500"></textarea>
          <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl uppercase tracking-wide hover:bg-orange-600 transition">
            Enviar mensaje
          </button>
        </form>
      </div>
    </div>
    <footer class="bg-gray-900 text-gray-400 text-center py-8">
      <p class="text-sm">© {{ currentYear }} Casa Moderna. Todos los derechos reservados.</p>
      <p class="text-xs text-gray-500">Diseñado por Casa Moderna Studio</p>
    </footer>
  </section>
</template>
