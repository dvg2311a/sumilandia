<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    resources: Object,
    permissions: Object
});
</script>

<template>

    <Head title="Recursos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Recursos</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">Listado de Recursos</h1>
                            <template v-if="permissions.create">
                                <Link href="/resources/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear</Link>
                            </template>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="resource in resources.data" :key="resource.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ resource.id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ resource.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ resource.description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a v-if="resource.file_path" :href="`/storage/${resource.file_path}`" target="_blank" class="text-blue-600 underline">Ver archivo</a>
                                            <a v-if="permissions.download && resource.file_path" :href="route('resources.download', resource.id)" class="text-green-600 underline ml-2" download>Descargar</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ resource.unit?.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <template v-if="permissions.view">
                                                <Link :href="`/resources/${resource.id}`" class="text-blue-600 hover:underline mr-4">Ver</Link>
                                            </template>
                                            <template v-if="permissions.edit">
                                                <Link :href="`/resources/${resource.id}/edit`" class="text-yellow-600 hover:underline mr-4">Editar</Link>
                                            </template>
                                            <template v-if="permissions.delete">
                                                <button @click="destroy(resource.id)" class="text-red-600 hover:underline">Eliminar</button>
                                            </template>
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
        resources: Object
    },
    methods: {
        destroy(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este recurso?')) {
                this.$inertia.delete(`/resources/${id}`);
            }
        }
    }
}
</script>
