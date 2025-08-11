<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    exercise: Object
});

function tryParseJSON(value) {
    try {
        return JSON.parse(value);
    } catch {
        return null;
    }
}

function normalizeField(field) {
    if (typeof field === 'string') {
        const parsed = tryParseJSON(field);
        if (parsed && Array.isArray(parsed)) {
            return parsed.map(o => o.frase || o);
        }
        return [field]; // texto plano
    }
    if (Array.isArray(field)) {
        return field.map(o => o.frase || o);
    }
    return [];
}

const frases = props.exercise;
frases.solution = normalizeField(frases.solution);
frases.options = normalizeField(frases.options);
</script>

<template>

    <Head title="Detalle Ejercicio" />
    <AuthenticatedLayout>
        <div class="page-content">
            <div class="back">
                <Link href="/exercises">
                <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                </Link>
            </div>
            <div class="card">
                <div class="header-actions">
                    <h1>Detalle del Ejercicio</h1>
                </div>
                <div class="unit-details">
                    <p><strong>Enunciado:</strong> {{ exercise.prompt }}</p>
                    <p><strong>Tipo de Ejercicio:</strong> {{ exercise.exercise_type?.name }}</p>
                    <p><strong>Lección:</strong> {{ exercise.lesson?.name }}</p>

                    <div v-if="exercise.options.length" class="exercise-options">
                        <p><strong>Opciones:</strong></p>
                        <ul>
                            <li v-for="(option, idx) in exercise.options" :key="idx">{{ option }}</li>
                        </ul>
                    </div>

                    <div v-if="exercise.solution.length" class="exercise-options">
                        <p><strong>Solución:</strong></p>
                        <ul>
                            <li v-for="(sol, idx) in exercise.solution" :key="idx">{{ sol }}</li>
                        </ul>
                    </div>

                    <p v-if="exercise.explanation">
                        <strong>Explicación:</strong> {{ exercise.explanation }}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
