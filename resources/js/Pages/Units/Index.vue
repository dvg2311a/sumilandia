<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  units: Array
});
</script>

<template>
  <Head title="Unidades" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Unidades</h2>
    </template>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-800">Listado de Unidades</h1>
              <Link href="/units/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear Unidad</Link>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiempo esperado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="unit in units" :key="unit.id">
                    <td class="px-6 py-4 whitespace-nowrap">{{ unit.id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ unit.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ unit.description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ unit.expected_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ unit.level?.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <Link :href="`/units/${unit.id}`" class="text-green-600 hover:underline mr-4">Ver</Link>
                      <Link :href="`/units/${unit.id}/edit`" class="text-blue-600 hover:underline mr-4">Editar</Link>
                      <button @click="destroy(unit.id)" class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
export default {
  props: {
    units: Array
  },
  methods: {
    destroy(id) {
      if (confirm('¿Estás seguro de que deseas eliminar esta unidad?')) {
        this.$inertia.delete(`/units/${id}`);
      }
    }
  }
}
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
