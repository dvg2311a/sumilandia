<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    resources: Object
});
</script>

<template>

    <Head title="Recursos" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Recursos</h2>
                <Link href="/resources/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Archivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="resource in resources.data" :key="resource.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ resource.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ resource.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ resource.description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a :href="`/storage/${resource.file_path}`" target="_blank"
                                            class="text-blue-600 underline">Ver archivo</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ resource.unit?.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <Link :href="`/resources/${resource.id}`" class="text-blue-600 hover:underline">Ver</Link>
                                        <Link :href="`/resources/${resource.id}/edit`" class="text-yellow-600 hover:underline">Editar</Link>
                                        <button @click="destroy(resource.id)" class="text-red-600 hover:underline">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
