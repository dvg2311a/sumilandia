<template>

    <Head title="Unidades" />
    <AuthenticatedLayout>
        <template #header>
            <h2>Unidades</h2>
        </template>
        <div class="container-table">
            <div class="table-responsive">
                <div class="header">
                    <h1>Listado de Unidades</h1>
                    <template v-if="permissions.create">
                        <Link href="/units/create"> <img src="/icons/create-icon.gif" alt=""> <span>Crear unidad</span>
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
                                <th>Tiempo esperado</th>
                                <th>Nivel</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="unit in units" :key="unit.id">
                                <td>{{ unit.id }}</td>
                                <td>{{ unit.name }}</td>
                                <td>{{ unit.description }}</td>
                                <td>{{ unit.expected_time }} Minutos</td>
                                <td>{{ unit.level?.name }}</td>
                                <td class="actions">
                                    <section>

                                        <template v-if="permissions.view">
                                            <Link :href="`/units/${unit.id}`"><img src="/icons/show-icon.gif"
                                                alt="Botón mostrar" class="btn-action"></Link>
                                        </template>
                                        <template v-if="permissions.edit">
                                            <Link :href="`/units/${unit.id}/edit`"><img src="/icons/edit-icon.gif"
                                                alt="Botón Editar" class="btn-action"></Link>
                                        </template>
                                        <template v-if="permissions.delete">
                                            <button @click="destroy(unit.id)"><img src="/icons/delete-icon.gif"
                                                    alt="Botón eliminar" class="btn-action"></button>
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    units: Array,
    permissions: Object
});

function destroy(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta unidad?')) {
        window.Inertia.delete(`/units/${id}`);
    }
}
</script>
