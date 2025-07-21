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
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Progreso de estudiantes</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex gap-4 mb-6 flex-wrap">
                            <div>
                                <label class="block mb-2 font-semibold">Unidad:</label>
                                <select v-model="unitId" @change="handleFilter" class="border rounded px-3 py-2">
                                    <option value="">Todas</option>
                                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 font-semibold">Lección:</label>
                                <select v-model="lessonId" @change="handleFilter" class="border rounded px-3 py-2">
                                    <option value="">Todas</option>
                                    <option v-for="lesson in lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name
                                        }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 font-semibold">Estudiante:</label>
                                <select v-model="userId" @change="handleFilter" class="border rounded px-3 py-2">
                                    <option value="">Todos</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.first_name }}
                                        {{
                                        user.last_name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 font-semibold">Estado:</label>
                                <select v-model="status" @change="handleFilter" class="border rounded px-3 py-2">
                                    <option value="">Todos</option>
                                    <option value="completado">Completado</option>
                                    <option value="en_progreso">En progreso</option>
                                    <option value="no_comenzado">No comenzado</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <table class="w-full border text-left">
                                <thead>
                                    <tr>
                                        <th class="border px-2 py-1">Estudiante</th>
                                        <th class="border px-2 py-1">Unidad</th>
                                        <th class="border px-2 py-1">Lección</th>
                                        <th class="border px-2 py-1">Progreso</th>
                                        <th class="border px-2 py-1">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in progress" :key="row.id">
                                        <td class="border px-2 py-1">{{ row.user?.first_name }} {{ row.user?.last_name
                                            }}</td>
                                        <td class="border px-2 py-1">{{row.lesson && row.lesson.unit ?
                                            row.lesson.unit.name :
                                            (units.find(u => u.id === row.lesson?.unit_id)?.name || '-') }}</td>
                                        <td class="border px-2 py-1">{{ row.lesson ? row.lesson.name : '-' }}</td>
                                        <td class="border px-2 py-1">
                                            <span
                                                :class="row.progress === 100 ? 'text-green-600 font-bold' : row.progress > 0 ? 'text-yellow-600 font-bold' : 'text-gray-500'">
                                                {{ row.progress }}%
                                            </span>
                                        </td>
                                        <td class="border px-2 py-1">
                                            <span
                                                :class="row.status === 'completado' ? 'text-green-600 font-bold' : row.status === 'en_progreso' ? 'text-yellow-600 font-bold' : 'text-gray-500'">
                                                {{ row.status === 'completado' ? 'Completado' : row.status ===
                                                'en_progreso' ?
                                                'En progreso' : 'No comenzado' }}
                                            </span>
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
