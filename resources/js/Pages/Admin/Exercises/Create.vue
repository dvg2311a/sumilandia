<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Form from './Form.vue';
const props = defineProps({
  types: Array,
  lessons: Array,
  errors: Object
});
const form = ref({
  prompt: '',
  options: [],
  solution: '',
  explanation: '',
  exercise_type_id: '',
  lesson_id: ''
});
function submit() {
  router.post('/exercises', form.value);
}
</script>

<template>
  <Head title="Crear Ejercicio" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Ejercicio</h2>
      </div>
    </template>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-800">Crear Ejercicio</h1>
              <Link href="/exercises" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</Link>
            </div>
            <Form :form="form" :types="types" :lessons="lessons" :errors="errors" :onSubmit="submit" :isEdit="false" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
