<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
const props = defineProps({
    exercises: Object
});
function destroy(id) {
    if (confirm('¿Seguro que deseas eliminar este ejercicio?')) {
        router.delete(`/admin/exercises/${id}`);
    }
}
</script>

<template>

    <Head title="Ejercicios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Ejercicios</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">Listado de Ejercicios</h1>
                            <Link href="/exercises/create"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear Ejercicio
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Enunciado</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tipo</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lección</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="exercise in exercises.data" :key="exercise.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ exercise.id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ exercise.prompt }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ exercise.exercise_type?.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ exercise.lesson?.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <Link :href="`/exercises/${exercise.id}`"
                                                class="text-green-600 hover:underline mr-4">Ver</Link>
                                            <Link :href="`/exercises/${exercise.id}/edit`"
                                                class="text-blue-600 hover:underline mr-4">Editar</Link>
                                            <button @click="destroy(exercise.id)"
                                                class="text-red-600 hover:underline">Eliminar</button>
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

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
