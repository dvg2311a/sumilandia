<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    resource: Object
});
</script>

<template>

    <Head title="Detalle de Recurso" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalle de Recurso</h2>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">{{ resource.name }}</h1>
                            <Link href="/resources"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver
                            </Link>
                        </div>
                        <div class="mb-4">
                            <strong>Descripción:</strong> {{ resource.description }}
                        </div>
                        <div class="mb-4">
                            <strong>Archivo:</strong> <a :href="`/storage/${props.resource.file_path}`" target="_blank"
                                class="text-blue-600 underline">Ver archivo</a>
                        </div>
                        <div class="mb-4">
                            <strong>Unidad:</strong> {{ resource.unit?.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
