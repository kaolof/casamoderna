<script setup>
const testimonials = [
  {
    id: 1,
    name: 'María González',
    role: 'Directora Creativa',
    message: 'Casa Moderna supo interpretar nuestro ADN de marca y llevarlo al espacio físico con un resultado impecable.',
    avatar: 'https://i.pravatar.cc/150?img=47'
  },
  {
    id: 2,
    name: 'Luis Fernández',
    role: 'Propietario residencial',
    message: 'Profesionales dedicados que cuidan cada detalle. El proceso fue transparente y el resultado superó las expectativas.',
    avatar: 'https://i.pravatar.cc/150?img=12'
  }
]
</script>

<template>
  <section id="testimonials" class="bg-gray-50 py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <p class="uppercase text-xs tracking-[0.4em] text-gray-500 mb-4">Lo que dicen nuestros clientes</p>
        <h2 class="text-3xl md:text-4xl font-semibold text-gray-900">La mejor garantía de nuestro trabajo</h2>
      </div>
      <div class="grid gap-8 md:grid-cols-2">
        <article v-for="testimonial in testimonials" :key="testimonial.id" class="bg-white p-8 rounded-3xl shadow">
          <div class="flex items-center gap-4 mb-6">
            <img :src="testimonial.avatar" :alt="testimonial.name" class="w-14 h-14 rounded-full object-cover" />
            <div>
              <p class="font-semibold text-gray-900">{{ testimonial.name }}</p>
              <p class="text-sm text-gray-500">{{ testimonial.role }}</p>
            </div>
          </div>
          <p class="text-gray-600 leading-relaxed">“{{ testimonial.message }}”</p>
        </article>
      </div>
    </div>
  </section>
</template>
