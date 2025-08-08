<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    resources: Object,
    permissions: Object
});

function destroy(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este recurso?')) {
        window.Inertia.delete(`/resources/${id}`);
    }
}
</script>

<template>
    <Head title="Recursos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="titulo-header">Recursos</h2>
        </template>
<div class="container-table">
    <div class="table-responsive">
        <div class="header">
            <h1 class="titulo-listado">Listado de Recursos</h1>
            <template v-if="permissions.create">
                        <Link href="/resources/create" class="btn btn-crear">
                            <img src="/icons/create-icon.gif" alt="Crear Recurso" />
                            Crear Recurso
                        </Link>
                    </template>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Archivo</th>
                        <th>Unidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="resource in resources.data" :key="resource.id">
                        <td class="id">{{ resource.id }}</td>
                        <td class="name">{{ resource.name }}</td>
                        <td class="description">{{ resource.description }}</td>
                        <td class="file">
                            <section class="file-actions">

                                <a v-if="resource.file_path" :href="`/storage/${resource.file_path}`" target="_blank">
                                    <img src="/icons/show-file-icon.gif" alt="Ver Archivo" class="btn-action"/>
                                </a>
                                <a v-if="permissions.download && resource.file_path"
                                :href="route('resources.download', resource.id)"  download>
                                <img src="/icons/download-icon.gif" alt="Descargar" class="btn-action"/>
                            </a>
                        </section>
                        </td>
                        <td class="unit">{{ resource.unit?.name }}</td>
                        <td class="actions">
                            <section>
                                <template v-if="permissions.view">
                                            <Link :href="`/resources/${resource.id}`">
                                                <img src="/icons/show-icon.gif" alt="Ver" class="btn-action"/>
                                            </Link>
                                <Link :href="`/resources/${resource.id}/edit`">
                                <img src="/icons/edit-icon.gif" alt="Editar" class="btn-action" />
                                </Link>
                                </template>
                                <template v-if="permissions.delete">
                                    <button @click="destroy(resource.id)">
                                        <img src="/icons/delete-icon.gif" alt="Eliminar" class="btn-action" />
                                    </button>
                                </template>
                            </section>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</AuthenticatedLayout>
</template>
