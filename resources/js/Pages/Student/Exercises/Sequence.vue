<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import MultipleChoice from './components/MultipleChoice.vue';
import TrueFalse from './components/TrueFalse.vue';
import FillBlank from './components/FillBlank.vue';
import OrderElements from './components/OrderElements.vue';
import MatchColumns from './components/MatchColumns.vue';
import MatchDefinitions from './components/MatchDefinitions.vue';
import CompleteDialog from './components/CompleteDialog.vue';

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

// Función para guardar el resumen de respuestas
async function saveSummary() {
    // Asegurarse de que todas las respuestas están registradas
    // Si no hay respuesta, se marca como 'sin respuesta'
    // Se asume que `props.exercises` contiene todos los ejercicios
    // map es para crear un array de intentos y cada intento contiene
    // el id del ejercicio, la lección, la unidad, la respuesta dada,
    // si es correcta, y el número de intento
    // idx es el índice del ejercicio actual
    // excercise es es un array de objetos que contienen los ejercicios
    const attempts = props.exercises.map((exercise, idx) => ({
        exercise_id: exercise.id,
        lesson_id: props.lesson.id,
        unit_id: props.lesson.unit_id, // asegúrate que lesson tiene unit_id
        answer_given: userAnswers.value[idx], // Respuesta del usuario
        is_correct: answered.value[idx] === true, // Resultado del ejercicio
        attempt_number: 1, // Asumiendo que es el primer intento
    }));

    await router.post(route('student.exercises.attemptsBatch'), {
        attempts
    }, {
        onSuccess: () => {
            finished.value = true;
            showSummary.value = false;
        }
    });
}

// Este función para reproducir sonidos de éxito o error
function playSound(type) {
    const audio = new Audio(type === 'success' ? '/sounds/success.mp3' : '/sounds/error.mp3');
    audio.play();
}

// Función para manejar la respuesta del usuario
// Aquí se actualizan las respuestas y se muestra el feedback
// Se asume que `handleAnswer` es llamada desde los componentes de ejercicios
function handleAnswer(result, userValue = null) {
    answered.value[current.value] = result; // Guardar si la respuesta fue correcta o incorrecta
    userAnswers.value[current.value] = userValue; // Guardar la respuesta del usuario
    lastAnswer.value = userValue;
    showFeedback.value = true; // Mostrar feedback al usuario
    playSound(result ? 'success' : 'error');
}

// Función para avanzar al siguiente ejercicio
// Resetea el estado de feedback y respuesta anterior
// Si es el último ejercicio, muestra el resumen
// Si no, avanza al siguiente ejercicio
function nextExercise() {
    showFeedback.value = false;
    lastAnswer.value = null;
    if (current.value < props.exercises.length - 1) {
        current.value++;
    } else {
        showSummary.value = true;
    }
}

// Función para ir a la lista de unidades
// Redirige al usuario a la página de unidades del estudiante
// Se asume que la ruta 'student.units.index' está definida en las rutas de In
function goToUnits() {
    router.get(route('student.units.index'));
}
</script>

<template>

    <Head :title="`Ejercicios de ${props.lesson.name}`" />
    <AuthenticatedLayout>
        <template #header>
            <h2>Ejercicios de {{ props.lesson.name }}</h2>
        </template>
        <div class="container-main">
            <template v-if="!finished && !showSummary">
                <div class="content-box">
                    <h1 class="title-content-box">Ejercicio {{ current + 1 }} de {{
                        exercises.length }}</h1>

                    <div class="info-exer-container">
                            <p> <span class="text">Tipo:</span> {{ exercises[current].exercise_type?.name }} </p>
                    </div>

                    <div class="info-exer-container">
                        <p>
                            <span class="text">Enunciado:</span> {{ exercises[current].prompt }}
                        </p>
                    </div>

                    <!-- Inputs dinámicos por tipo de ejercicio -->
                    <component :is="exercises[current].exercise_type?.name === 'Opción múltiple' ? MultipleChoice
                        : exercises[current].exercise_type?.name === 'Verdadero o falso' ? TrueFalse
                            : exercises[current].exercise_type?.name === 'Completar espacios' ? FillBlank
                                : exercises[current].exercise_type?.name === 'Ordenar elementos' ? OrderElements
                                    : exercises[current].exercise_type?.name === 'Relacionar columnas' ? MatchColumns
                                        : exercises[current].exercise_type?.name === 'Emparejar definiciones' ? MatchDefinitions
                                            : exercises[current].exercise_type?.name === 'Completar diálogo' ? CompleteDialog
                                                : null"
                        v-if="['Opción múltiple', 'Verdadero o falso', 'Completar espacios', 'Ordenar elementos', 'Relacionar columnas', 'Emparejar definiciones', 'Completar diálogo'].includes(exercises[current].exercise_type?.name)"
                        :exercise="exercises[current]" :showFeedback="showFeedback" :lastAnswer="lastAnswer"
                        :handleAnswer="handleAnswer" :nextExercise="nextExercise" />
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
                                        <span v-if="userAnswers[idx] !== undefined">{{ userAnswers[idx]
                                            }}</span>
                                        <span v-else class="text-gray-500">Sin respuesta</span>
                                    </td>
                                    <td class="border px-2 py-1">
                                        <span v-if="answered[idx] === true"
                                            class="text-green-600 font-bold">Correcto</span>
                                        <span v-else-if="answered[idx] === false"
                                            class="text-red-600 font-bold">Incorrecto</span>
                                        <span v-else class="text-gray-500">Sin respuesta</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        @click="saveSummary">Finalizar</button>
                </div>
            </template>
            <template v-else>
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">¡Has terminado la ronda de ejercicios!</h2>
                </div>
            </template>
        </div>

    </AuthenticatedLayout>
</template>
