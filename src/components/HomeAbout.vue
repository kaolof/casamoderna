<template>
  <section id="about" class="bg-white py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto grid gap-12 lg:grid-cols-2 items-center">
      <!-- Collage de imágenes -->
      <div class="grid grid-cols-2 gap-4 auto-rows-[12rem] sm:auto-rows-[14rem] md:auto-rows-[16rem]">
        <!-- Imagen superior izquierda -->
        <div class="col-span-1 row-span-1 overflow-hidden shadow-lg">
          <img
            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=600&fit=crop"
            alt="Profesional de arquitectura"
            class="w-full h-full object-cover"
          />
        </div>

        <!-- Imagen vertical derecha (ocupa dos filas) -->
        <div class="col-span-1 row-span-2 overflow-hidden shadow-lg relative">
          <img
            src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&h=1200&fit=crop"
            alt="Diseño interior con plantas"
            class="w-full h-full object-cover"
          />
          <div class="absolute top-6 right-6 bg-white/90 backdrop-blur px-4 py-2 rounded-full text-xs font-semibold tracking-[0.3em] text-gray-800">
            +15 AÑOS
          </div>
        </div>

        <!-- Imagen inferior izquierda. -->
        <div class="col-span-1 row-span-1 overflow-hidden shadow-lg">
          <img
            src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=600&h=600&fit=crop"
            alt="Proyecto arquitectónico moderno"
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <!-- Contenido de texto -->
      <div class="space-y-6 lg:pl-8">
        <p class="text-sm font-semibold text-orange-500 tracking-[0.4em]">
          EXPERIENCIA COMPROBADA
        </p>
        <p class="text-lg text-gray-600 font-light tracking-wide uppercase">Tu visión, nuestra pasión</p>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight text-balance">
          Arquitectura con propósito
        </h2>
        <p class="text-gray-700 leading-relaxed text-base">
          Creamos espacios que cuentan historias, combinando materiales nobles, confort térmico y luz natural. Nuestro equipo acompaña cada etapa del proyecto, desde la idea inicial hasta la entrega final, cuidando presupuestos y cronogramas.
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-4">
          <div>
            <p class="text-3xl font-semibold text-gray-900">150+</p>
            <p class="text-xs uppercase tracking-wide text-gray-500">Proyectos</p>
          </div>
          <div>
            <p class="text-3xl font-semibold text-gray-900">25</p>
            <p class="text-xs uppercase tracking-wide text-gray-500">Especialistas</p>
          </div>
          <div>
            <p class="text-3xl font-semibold text-gray-900">12</p>
            <p class="text-xs uppercase tracking-wide text-gray-500">Ciudades</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// Sección estática
</script>

<style scoped>
section {
  background-color: #ffffff;
}
</style>
