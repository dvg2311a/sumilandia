<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  lesson: Object
});
</script>

<template>
  <Head title="Detalle Lección" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalle de la Lección</h2>
      </div>
    </template>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-800">Detalle de la Lección</h1>
              <Link href="/lessons" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</Link>
            </div>
            <div class="mb-6">
              <p class="text-gray-700 mb-2"><span class="font-semibold">Nombre:</span> {{ lesson.name }}</p>
              <p class="text-gray-700 mb-2"><span class="font-semibold">Descripción:</span> {{ lesson.description }}</p>
              <p class="text-gray-700 mb-2"><span class="font-semibold">Unidad:</span> {{ lesson.unit?.name }}</p>
              <p class="text-gray-700 mb-2"><span class="font-semibold">Contenido:</span> {{ lesson.content }}</p>
              <p class="text-gray-700"><span class="font-semibold">ID:</span> {{ lesson.id }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
