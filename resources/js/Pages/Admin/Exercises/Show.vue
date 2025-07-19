<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
const props = defineProps({
  exercise: Object
});
</script>
<template>
  <Head title="Detalle Ejercicio" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalle del Ejercicio</h2>
    </template>
    <div class="py-12">
      <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="mb-4">
              <strong class="block text-gray-700">Enunciado:</strong>
              <span>{{ exercise.prompt }}</span>
            </div>
            <div class="mb-4">
              <strong class="block text-gray-700">Tipo de Ejercicio:</strong>
              <span>{{ exercise.exercise_type?.name }}</span>
            </div>
            <div class="mb-4">
              <strong class="block text-gray-700">Lección:</strong>
              <span>{{ exercise.lesson?.name }}</span>
            </div>
            <div v-if="exercise.options && exercise.options.length" class="mb-4">
              <strong class="block text-gray-700">Opciones:</strong>
              <ul class="list-disc ml-6">
                <li v-for="(option, idx) in exercise.options" :key="idx">{{ option }}</li>
              </ul>
            </div>
            <div class="mb-4">
              <strong class="block text-gray-700">Solución:</strong>
              <span>{{ exercise.solution }}</span>
            </div>
            <div v-if="exercise.explanation" class="mb-4">
              <strong class="block text-gray-700">Explicación:</strong>
              <span>{{ exercise.explanation }}</span>
            </div>
            <div class="flex justify-end">
              <Link :href="`/exercises`" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Volver</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
