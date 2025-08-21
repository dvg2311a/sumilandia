<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { reactive, defineProps } from 'vue';

const props = defineProps({
    exercises: Object,
    permissions: Object,
    filters: Object,
    lessons: Array,
    types: Array,
});

const filters = reactive({
  lesson: props.filters.lesson || '',
  type: props.filters.type || '',
})

const applyFilters = () => {
    router.get(route('exercises.index'), filters)
}


function destroy(id) {
    if (confirm('¿Seguro que deseas eliminar este ejercicio?')) {
        router.delete(route('exercises.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({
                    only: ['exercises'],
                    preserveState: true
                });
            }
        });
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
                    <div class="filtro">
                        <label for="filter" class="label-filter">Filtrar por lección:</label>
                        <select v-model="filters.lesson" @change="applyFilters" class="select-filter">
                            <option value="">Todas las lecciones</option>
                            <option v-for="lesson in lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name }}</option>
                        </select>
                    </div>
                    <div class="filtro">
                        <label for="filter-type" class="label-filter">Filtrar por tipo de ejercicio?</label>
                        <select v-model="filters.type" @change="applyFilters" id="filter-type" class="select-filter">
                            <option value="">Todos los tipos</option>
                            <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
                        </select>
                    </div>
                    <template v-if="permissions.create">
                        <Link :href="route('exercises.create')" class="btn btn-crear">
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
                                            <Link :href="route('exercises.show', exercise.id)">
                                            <img src="/icons/show-icon.gif" alt="Ver" class="btn-action" />
                                            </Link>
                                        </template>
                                        <template v-if="permissions.edit">
                                            <Link :href="route('exercises.edit', exercise.id)">
                                            <img src="/icons/edit-icon.gif" alt="Editar" class="btn-action" />
                                            </Link>
                                        </template>
                                        <template v-if="permissions.delete">
                                            <button @click="destroy(exercise.id)" type="button">
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

            <div class="pagination" v-if="exercises.data.length > 0">
                <Link v-if="exercises.links.prev"
                    :href="exercises.links.prev + (filter_exercises ? `&lesson_id=${filter_exercises}` : '')"
                    class="btn-pagination">
                Anterior
                </Link>

                <span class="pagination-info">
                    Página {{ exercises.current_page }} de {{ exercises.last_page }}
                </span>

                <Link v-if="exercises.links.next"
                    :href="exercises.links.next + (filter_exercises ? `&lesson_id=${filter_exercises}` : '')"
                    class="btn-pagination">
                Siguiente
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
