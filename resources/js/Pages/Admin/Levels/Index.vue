<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

</script>

<template>

    <Head title="Niveles" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="titulo-header">Niveles</h2>
        </template>

        <div class="container-table">
            <div class="table-responsive">
                <div class="header">
                    <h1 class="titulo-listado">Listado de Niveles</h1>
                    <template v-if="permissions.create">
                        <Link href="/levels/create" class="btn btn-crear">
                        <img src="/icons/create-icon.gif" alt="">
                        <span>Crear nivel</span>
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="level in levels" :key="level.id">
                                <td>{{ level.id }}</td>
                                <td>{{ level.name }}</td>
                                <td>{{ level.description }}</td>
                                <td class="actions">
                                    <section>
                                        <template v-if="permissions.view">
                                            <Link :href="`/levels/${level.id}`">
                                            <img src="/icons/show-icon.gif" alt="Ver" class="btn-action" />
                                            </Link>
                                        </template>
                                        <template v-if="permissions.edit">
                                            <Link :href="`/levels/${level.id}/edit`">
                                            <img src="/icons/edit-icon.gif" alt="Editar" class="btn-action" />
                                            </Link>
                                        </template>
                                        <template v-if="permissions.delete">
                                            <button @click="destroy(level.id)">
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
<script>
export default {
    props: {
        levels: Array,
        permissions: Object
    },
    methods: {
        destroy(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este nivel?')) {
                this.$inertia.delete(`/levels/${id}`);
            }
        }
    }
}
</script>
