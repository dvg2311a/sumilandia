<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import MultipleChoice from './components/MultipleChoice.vue';
import TrueFalse from './components/TrueFalse.vue';
import FillBlank from './components/FillBlank.vue';
import OrderElements from './components/OrderElements.vue';
import MatchColumns from './components/MatchColumns.vue';

const props = defineProps({
    lesson: Object,
    exercises: Array
});

const current = ref(0);
const answered = ref([]);
const userAnswers = ref([]);
const showFeedback = ref(false);
const finished = ref(false);
const showSummary = ref(false);
const lastAnswer = ref(null);

function playSound(type) {
    const audio = new Audio(type === 'success' ? '/sounds/success.mp3' : '/sounds/error.mp3');
    audio.play();
}

function handleAnswer(result, userValue = null) {
    answered.value[current.value] = result;
    userAnswers.value[current.value] = userValue;
    lastAnswer.value = userValue;
    showFeedback.value = true;
    playSound(result ? 'success' : 'error');
}

function nextExercise() {
    showFeedback.value = false;
    lastAnswer.value = null;
    if (current.value < props.exercises.length - 1) {
        current.value++;
    } else {
        showSummary.value = true;
    }
}

function goToUnits() {
    router.get(route('student.units.index'));
}
</script>

<template>
    <Head :title="`Ejercicios de ${props.lesson.name}`" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Ejercicios de {{ props.lesson.name }}</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <template v-if="!finished && !showSummary">
                            <div class="mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Ejercicio {{ current + 1 }} de {{ exercises.length }}</h1>
                                <div class="mb-4">
                                    <span class="font-semibold">Tipo:</span> {{ exercises[current].exercise_type?.name }}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Enunciado:</span> {{ exercises[current].prompt }}
                                </div>
                                <!-- Inputs dinámicos por tipo de ejercicio -->
                                <component
                                    :is="exercises[current].exercise_type?.name === 'Opción múltiple' ? MultipleChoice
                                        : exercises[current].exercise_type?.name === 'Verdadero o falso' ? TrueFalse
                                        : exercises[current].exercise_type?.name === 'Completar espacios' ? FillBlank
                                        : exercises[current].exercise_type?.name === 'Ordenar elementos' ? OrderElements
                                        : exercises[current].exercise_type?.name === 'Relacionar columnas' ? MatchColumns
                                        : null"
                                    v-if="['Opción múltiple', 'Verdadero o falso', 'Completar espacios', 'Ordenar elementos', 'Relacionar columnas'].includes(exercises[current].exercise_type?.name)"
                                    :exercise="exercises[current]"
                                    :showFeedback="showFeedback"
                                    :lastAnswer="lastAnswer"
                                    :handleAnswer="handleAnswer"
                                    :nextExercise="nextExercise"
                                />
                            </div>
                        </template>
                        <template v-else-if="showSummary">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold mb-4">Resumen de tus respuestas</h2>
                                <div class="mb-6">
                                    <table class="mx-auto w-full max-w-xl text-left border">
                                        <thead>
                                            <tr>
                                                <th class="border px-2 py-1">#</th>
                                                <th class="border px-2 py-1">Enunciado</th>
                                                <th class="border px-2 py-1">Tu respuesta</th>
                                                <th class="border px-2 py-1">Resultado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(exercise, idx) in exercises" :key="idx">
                                                <td class="border px-2 py-1">{{ idx + 1 }}</td>
                                                <td class="border px-2 py-1">{{ exercise.prompt }}</td>
                                                <td class="border px-2 py-1">
                                                    <span v-if="userAnswers[idx] !== undefined">{{ userAnswers[idx] }}</span>
                                                    <span v-else class="text-gray-500">Sin respuesta</span>
                                                </td>
                                                <td class="border px-2 py-1">
                                                    <span v-if="answered[idx] === true" class="text-green-600 font-bold">Correcto</span>
                                                    <span v-else-if="answered[idx] === false" class="text-red-600 font-bold">Incorrecto</span>
                                                    <span v-else class="text-gray-500">Sin respuesta</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="finished = true; showSummary = false;">Finalizar</button>
                            </div>
                        </template>
                        <template v-else>
                            <div class="text-center">
                                <h2 class="text-2xl font-bold mb-4">¡Has terminado la ronda de ejercicios!</h2>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="goToUnits">
                                    Volver a la lista de unidades
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
