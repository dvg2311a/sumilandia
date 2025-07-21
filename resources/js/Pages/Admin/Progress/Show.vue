<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    units: Array,
    lessons: Array,
    attempts: Array,
    lessonProgress: Array,
    unitProgress: Array
});

const filter = ref('all');
</script>

<template>
    <Head :title="`Detalle de estudiante: ${props.user.first_name} ${props.user.last_name}`" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalle de estudiante</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ props.user.first_name }} {{ props.user.last_name }}</h3>
                                <div class="text-gray-600 mb-2">ID: {{ props.user.id }} | Email: {{ props.user.email }}</div>
                            </div>
                            <div class="flex gap-6 mt-4 md:mt-0">
                                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded shadow">
                                    <div class="font-bold text-lg">{{ unitProgress.length }}</div>
                                    <div class="text-xs">Unidades trabajadas</div>
                                </div>
                                <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow">
                                    <div class="font-bold text-lg">{{ lessonProgress.length }}</div>
                                    <div class="text-xs">Lecciones trabajadas</div>
                                </div>
                                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded shadow">
                                    <div class="font-bold text-lg">{{ attempts.length }}</div>
                                    <div class="text-xs">Intentos realizados</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-8">
                            <div class="flex gap-4 mb-4">
                                <label class="font-semibold">Filtrar vista:</label>
                                <select v-model="filter" class="border rounded px-3 py-2">
                                    <option value="all">Ver todo</option>
                                    <option value="units">Solo unidades</option>
                                    <option value="lessons">Solo lecciones</option>
                                    <option value="attempts">Solo intentos</option>
                                </select>
                            </div>
                            <div v-if="filter === 'all' || filter === 'units'">
                                <h4 class="font-semibold mb-2 text-lg">Unidades trabajadas</h4>
                                <table class="w-full border text-left mb-4">
                                    <thead>
                                        <tr>
                                            <th class="border px-2 py-1">Unidad</th>
                                            <th class="border px-2 py-1">Progreso</th>
                                            <th class="border px-2 py-1">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="unit in unitProgress" :key="unit.id">
                                            <td class="border px-2 py-1">{{ unit.unit?.name }}</td>
                                            <td class="border px-2 py-1">{{ unit.progress }}%</td>
                                            <td class="border px-2 py-1">
                                                <span :class="unit.status === 'completado' ? 'text-green-600 font-bold' : unit.status === 'en_progreso' ? 'text-yellow-600 font-bold' : 'text-gray-500'">
                                                    {{ unit.status === 'completado' ? 'Completado' : unit.status === 'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="filter === 'all' || filter === 'lessons'">
                                <h4 class="font-semibold mb-2 text-lg">Lecciones trabajadas</h4>
                                <table class="w-full border text-left mb-4">
                                    <thead>
                                        <tr>
                                            <th class="border px-2 py-1">Lección</th>
                                            <th class="border px-2 py-1">Unidad</th>
                                            <th class="border px-2 py-1">Progreso</th>
                                            <th class="border px-2 py-1">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="lesson in lessonProgress" :key="lesson.id">
                                            <td class="border px-2 py-1">{{ lesson.lesson?.name }}</td>
                                            <td class="border px-2 py-1">{{ lesson.lesson?.unit?.name }}</td>
                                            <td class="border px-2 py-1">{{ lesson.progress }}%</td>
                                            <td class="border px-2 py-1">
                                                <span :class="lesson.status === 'completado' ? 'text-green-600 font-bold' : lesson.status === 'en_progreso' ? 'text-yellow-600 font-bold' : 'text-gray-500'">
                                                    {{ lesson.status === 'completado' ? 'Completado' : lesson.status === 'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="filter === 'all' || filter === 'attempts'">
                                <h4 class="font-semibold mb-2 text-lg">Intentos realizados</h4>
                                <table class="w-full border text-left">
                                    <thead>
                                        <tr>
                                            <th class="border px-2 py-1">Lección</th>
                                            <th class="border px-2 py-1">Ejercicio</th>
                                            <th class="border px-2 py-1">Respuesta</th>
                                            <th class="border px-2 py-1">Correcta</th>
                                            <th class="border px-2 py-1">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="attempt in attempts" :key="attempt.id">
                                            <td class="border px-2 py-1">{{ attempt.lesson?.name }}</td>
                                            <td class="border px-2 py-1">{{ attempt.exercise?.name }}</td>
                                            <td class="border px-2 py-1">{{ attempt.answer }}</td>
                                            <td class="border px-2 py-1">
                                                <span :class="attempt.is_correct ? 'text-green-600 font-bold' : 'text-red-600 font-bold'">
                                                    {{ attempt.is_correct ? 'Correcta' : 'Incorrecta' }}
                                                </span>
                                            </td>
                                            <td class="border px-2 py-1">{{ attempt.created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
