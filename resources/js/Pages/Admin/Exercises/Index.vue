<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    exercises: Object,
    permissions: Object
});
function destroy(id) {
    if (confirm('¿Seguro que deseas eliminar este ejercicio?')) {
        router.delete(`/exercises/${id}`);
    }
}
</script>

<template>
    <Head title="Ejercicios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="titulo-header">Ejercicios</h2>
        </template>
        <div class="container-table">
            <div class="table-responsive">
                <div class="header">
                    <h1 class="titulo-listado">Listado de Ejercicios</h1>
                    <template v-if="permissions.create">
                        <Link href="/exercises/create" class="btn btn-crear">
                            <img src="/icons/create-icon.gif" alt="Crear Ejercicio" />
                            Crear Ejercicio
                        </Link>
                    </template>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Enunciado</th>
                                <th>Tipo</th>
                                <th>Lección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="exercise in exercises.data" :key="exercise.id">
                                <td class="id">{{ exercise.id }}</td>
                                <td class="pompt">{{ exercise.prompt }}</td>
                                <td class="type">{{ exercise.exercise_type?.name }}</td>
                                <td class="lession">{{ exercise.lesson?.name }}</td>
                                <td class="actions">
                                    <section>
                                        <template v-if="permissions.view">
                                            <Link :href="`/exercises/${exercise.id}`">
                                                <img src="/icons/show-icon.gif" alt="Ver" class="btn-action"/>
                                            </Link>
                                        </template>
                                        <template v-if="permissions.edit">
                                            <Link :href="`/exercises/${exercise.id}/edit`">
                                                <img src="/icons/edit-icon.gif" alt="Editar" class="btn-action"/>
                                            </Link>
                                        </template>
                                        <template v-if="permissions.delete">
                                            <button @click="destroy(exercise.id)">
                                                <img src="/icons/delete-icon.gif" alt="Eliminar" class="btn-action"/>
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

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
