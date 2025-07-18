<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  level: Object
});
</script>

<template>
  <Head title="Detalle Nivel" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalle del Nivel</h2>
        <a href="/levels" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">Volver</a>
      </div>
    </template>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="mb-6">
              <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ level.name }}</h1>
              <p class="text-gray-700 mb-2"><span class="font-semibold">Descripción:</span> {{ level.description }}</p>
              <p class="text-gray-700"><span class="font-semibold">ID:</span> {{ level.id }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
