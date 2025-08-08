<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    lessons: Object,
    permissions: Object
});


</script>

<template>

    <Head title="Lecciones" />
    <AuthenticatedLayout>
        <div class="container-table">
            <div class="table-responsive">
                <div class="header">
                    <h1>Listado de Lecciones</h1>
                    <template v-if="permissions.create">
                        <Link href="/lessons/create">
                        <img src="/icons/create-icon.gif" alt="">
                        <span>Crear lección</span>
                        </Link>
                    </template>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="lesson in lessons.data" :key="lesson.id">
                                <td>{{ lesson.id }}</td>
                                <td>{{ lesson.name }}</td>
                                <td>{{ lesson.unit?.name }}</td>
                                <td class="actions">
                                    <section>
                                        <template v-if="permissions.view">
                                            <Link :href="`/lessons/${lesson.id}`">
                                            <img src="/icons/show-icon.gif" alt="Botón mostrar" class="btn-action">
                                            </Link>
                                        </template>
                                        <template v-if="permissions.edit">
                                            <Link :href="`/lessons/${lesson.id}/edit`">
                                            <img src="/icons/edit-icon.gif" alt="Botón Editar" class="btn-action">
                                            </Link>
                                        </template>
                                        <template v-if="permissions.delete">
                                            <button @click="destroy(lesson.id)">
                                                <img src="/icons/delete-icon.gif" alt="Botón eliminar"
                                                    class="btn-action">
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
            lessons: Object
        },
        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta lección?')) {
                    this.$inertia.delete(`/lessons/${id}`);
                }
            }
        }
    };
</script>
