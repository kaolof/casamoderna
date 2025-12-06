<script setup>
const props = defineProps({
  id: {
    type: String,
    required: true
  }
})
</script>

<template>
  <section class="max-w-4xl mx-auto px-4 py-24 space-y-6">
    <p class="uppercase text-xs tracking-[0.4em] text-gray-500">Proyecto</p>
    <h1 class="text-4xl font-semibold text-gray-900">Proyecto {{ props.id }}</h1>
    <p class="text-gray-600">
      Aquí se renderizará la información detallada del proyecto seleccionado. La ruta dinámica
      permitirá cargar planos, galerías, métricas y testimonios específicos para cada caso.
    </p>
  </section>
</template>
