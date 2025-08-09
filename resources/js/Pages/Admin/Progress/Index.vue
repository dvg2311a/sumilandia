<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    units: Array,
    users: Array,
    lessons: Array,
    progress: Array,
    selectedUnit: [String, Number, null],
    selectedUser: [String, Number, null],
    selectedLesson: [String, Number, null],
    selectedStatus: [String, null]
});

const unitId = ref(props.selectedUnit || '');
const userId = ref(props.selectedUser || '');
const lessonId = ref(props.selectedLesson || '');
const status = ref(props.selectedStatus || '');

function handleFilter() {
    router.get(route('admin.progress.index'), {
        unit_id: unitId.value,
        user_id: userId.value,
        lesson_id: lessonId.value,
        status: status.value
    });
}
</script>

<template>

    <Head title="Progreso de estudiantes" />
    <AuthenticatedLayout>
        <template #header>
            <h2>Progreso de estudiantes</h2>
        </template>
        <div class="container-table">
            <div class="table-responsive">
                    <div class="card-body">
                        <div class="filters">
                            <div class="filter-group">
                                <label>Unidad:</label>
                                <select v-model="unitId" @change="handleFilter">
                                    <option value="">Todas</option>
                                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Lección:</label>
                                <select v-model="lessonId" @change="handleFilter">
                                    <option value="">Todas</option>
                                    <option v-for="lesson in lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name }}</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Estudiante:</label>
                                <select v-model="userId" @change="handleFilter">
                                    <option value="">Todos</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.first_name }} {{ user.last_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Estado:</label>
                                <select v-model="status" @change="handleFilter">
                                    <option value="">Todos</option>
                                    <option value="completado">Completado</option>
                                    <option value="en_progreso">En progreso</option>
                                    <option value="no_comenzado">No comenzado</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Unidad</th>
                                        <th>Lección</th>
                                        <th>Progreso</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in progress" :key="row.id">
                                        <td>{{ row.user?.first_name }} {{ row.user?.last_name }}</td>
                                        <td>{{ row.lesson && row.lesson.unit ? row.lesson.unit.name : (units.find(u => u.id === row.lesson?.unit_id)?.name || '-') }}</td>
                                        <td>{{ row.lesson ? row.lesson.name : '-' }}</td>
                                        <td>
                                            <span :class="{
                                                'completed': row.progress === 100,
                                                'in-progress': row.progress > 0 && row.progress < 100,
                                                'not-started': row.progress === 0
                                            }">
                                                {{ row.progress }}%
                                            </span>
                                        </td>
                                        <td>
                                            <span :class="{
                                                'completed': row.status === 'completado',
                                                'in-progress': row.status === 'en_progreso',
                                                'not-started': row.status === 'no_comenzado'
                                            }">
                                                {{ row.status === 'completado' ? 'Completado' : row.status === 'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                            </span>
                                        </td>
                                        <td class="actions">
                                            <section>
                                                <button
                                                v-if="row.user"
                                                @click="router.get(route('admin.progress.show', row.user.id))"
                                                class="btn-action"
                                                >
                                                <img src="/icons/show-icon.gif" alt="Ver detalles" class="btn-action"/>
                                            </button>
                                        </section>
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
