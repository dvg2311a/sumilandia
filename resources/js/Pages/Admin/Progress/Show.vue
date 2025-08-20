<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { stringify } from 'postcss';
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

function formatAnswer(answer) {
    if (!answer && answer !== 0 && answer !== false) return '';

    let parsed = answer;

    // Intentar parsear si es string
    if (typeof answer === 'string') {
        try {
            parsed = JSON.parse(answer);
        } catch {
            return answer; // Devolver string original si no es JSON válido
        }
    }

    // Manejar arrays
    if (Array.isArray(parsed)) {
        return parsed.map(item => {
            if (typeof item === 'object' && item !== null) {
                return item.frase || JSON.stringify(item);
            }
            return String(item);
        }).join(', ');
    }

    // Manejar objetos
    if (typeof parsed === 'object' && parsed !== null) {
        return Object.entries(parsed)
            .map(([key, value]) => {
                // Formatear valores anidados recursivamente
                if (typeof value === 'object' && value !== null) {
                    return `${key}: (${formatAnswer(value)})`;
                }
                return stringify`${key}: ${value}`;
            })
            .join(', ');
    }

    // Para primitivos (number, boolean, etc.)
    return String(parsed);
}

// Convertir la hora
function horaLocal(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleString('es-NI', {
        timeZone: 'America/Managua',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
}
</script>


<template>

    <Head :title="`Detalle de estudiante: ${props.user.first_name} ${props.user.last_name}`" />
    <AuthenticatedLayout>

        <div class="container-table">
            <section>

                <div class="back">
                    <a href="/progress" class="btn-return">
                        <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </a>
                </div>
                <div class="unit-details">
                    <div class="user-info">
                        <h3>{{ props.user.first_name }} {{ props.user.last_name }}</h3>
                        <p>ID: {{ props.user.id }} | Email: {{ props.user.email }}</p>
                    </div>
                    <div class="progress-summary">
                        <div class="progress-item one">
                            <p class="title-progress">Unidades trabajadas</p>
                            <p class="text-progress">{{ unitProgress.length }}</p>
                        </div>
                        <div class="progress-item two">
                            <p class="title-progress">Lecciones trabajadas</p>
                            <p class="text-progress">{{ lessonProgress.length }}</p>
                        </div>
                        <div class="progress-item three">
                            <p class="title-progress">Intentos realizados</p>
                            <p class="text-progress">{{ attempts.length }}</p>
                        </div>
                    </div>
                    <div class="filter-options">
                        <label>Filtrar vista:</label>
                        <select v-model="filter">
                            <option value="all">Ver todo</option>
                            <option value="units">Solo unidades</option>
                            <option value="lessons">Solo lecciones</option>
                            <option value="attempts">Solo intentos</option>
                        </select>
                    </div>
                </div>
            </section>


            <div class="table-responsive">
                <div v-if="filter === 'all' || filter === 'units'" class="table-container">
                    <h4>Unidades trabajadas</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Unidad</th>
                                <th>Progreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="unit in unitProgress" :key="unit.id">
                                <td>{{ unit.unit?.name }}</td>
                                <td>{{ unit.progress }}%</td>
                                <td class="status">
                                    <span
                                        :class="unit.status === 'completado' ? 'text-green' : unit.status === 'en_progreso' ? 'text-yellow' : 'text-gray'">
                                        {{ unit.status === 'completado' ? 'Completado' : unit.status ===
                                            'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="filter === 'all' || filter === 'lessons'" class="table-container">
                    <h4>Lecciones trabajadas</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lección</th>
                                <th>Unidad</th>
                                <th>Progreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="lesson in lessonProgress" :key="lesson.id">
                                <td>{{ lesson.lesson?.name }}</td>
                                <td>{{ lesson.lesson?.unit?.name }}</td>
                                <td class="status">{{ lesson.progress }}%</td>
                                <td>
                                    <span
                                        :class="lesson.status === 'completado' ? 'text-green' : lesson.status === 'en_progreso' ? 'text-yellow' : 'text-gray'">
                                        {{ lesson.status === 'completado' ? 'Completado' : lesson.status ===
                                            'en_progreso' ? 'En progreso' : 'No comenzado' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="filter === 'all' || filter === 'attempts'" class="table-container">
                    <h4>Intentos realizados</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lección</th>
                                <th>Ejercicio</th>
                                <th>Respuesta</th>
                                <th>Correcta</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="attempt in attempts" :key="attempt.id">
                                <td>{{ attempt.lesson?.name }}</td>
                                <td>{{ attempt.exercise?.prompt }}</td>
                                <td class="status">{{ formatAnswer(attempt.answer_given) }}</td>

                                <td>
                                    <span :class="attempt.is_correct ? 'text-green' : 'text-red'">
                                        {{ attempt.is_correct ? 'Correcta' : 'Incorrecta' }}
                                    </span>
                                </td>
                                <td>{{ horaLocal(attempt.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
