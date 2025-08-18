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
    <div class="response-container">
        <div v-if="frases.length" class="complete-exercise">
            <div v-for="(frase, idx) in frases" :key="idx" class="complete-exercise-item">
                <template v-if="frase.frase && frase.frase.includes('_')">
                    <span>{{ frase.frase.split('_')[0] }}</span>
                    <input v-model="studentAnswers[idx]" :disabled="props.showFeedback" type="text" class=""
                        placeholder="Completa aquí" />
                    <span v-if="frase.frase.split('_')[1]">{{ frase.frase.split('_')[1] }}</span>
                </template>
                <template v-else>
                    <span>{{ frase.frase }}</span>
                </template>
            </div>
        </div>

        <div class="button-container">
            <button @click="checkAnswer" :disabled="props.showFeedback">
                Comprobar respuesta
            </button>
            <div v-if="props.showFeedback">
                <button class="" @click="props.nextExercise">Siguiente</button>
            </div>
        </div>
    </div>
</template>
