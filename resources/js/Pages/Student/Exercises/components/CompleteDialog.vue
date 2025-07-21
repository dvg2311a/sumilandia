<script setup>
import { ref } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: Array,
    handleAnswer: Function,
    nextExercise: Function
});
const frases = Array.isArray(props.exercise.options) ? props.exercise.options : [];
// Cada frase tiene un solo hueco (guion bajo), así que la cantidad de huecos es igual a frases.length
const studentAnswers = ref(frases.map(() => ''));
function setAnswer(idx, val) {
    studentAnswers.value[idx] = val;
}
function checkAnswer() {
    const solutionArray = Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution];
    const isCorrect = studentAnswers.value.every((ans, idx) => ans === solutionArray[idx]);
    props.handleAnswer(isCorrect, JSON.parse(JSON.stringify(studentAnswers.value)));
}
</script>
<template>
    <div class="mb-4">
        <div v-if="frases.length">
            <div class="space-y-2">
                <div v-for="(frase, idx) in frases" :key="idx" class="flex items-center gap-2 mb-2">
                    <template v-if="frase.frase && frase.frase.includes('_')">
                        <span>{{ frase.frase.split('_')[0] }}</span>
                        <input
                            v-model="studentAnswers[idx]"
                            :disabled="props.showFeedback"
                            type="text"
                            class="border-gray-300 rounded-md shadow-sm w-40"
                            placeholder="Completa aquí"
                        />
                        <span v-if="frase.frase.split('_')[1]">{{ frase.frase.split('_')[1] }}</span>
                    </template>
                    <template v-else>
                        <span>{{ frase.frase }}</span>
                    </template>
                </div>
            </div>
        </div>
        <button
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mt-2"
            @click="checkAnswer"
            :disabled="props.showFeedback"
        >
            Comprobar respuesta
        </button>
        <div v-if="props.showFeedback">
            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="props.nextExercise">Siguiente</button>
        </div>
    </div>
</template>
