<script setup>
import { ref } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: String,
    handleAnswer: Function,
    nextExercise: Function
});
const answer = ref('');
// Asegurarse que la solución sea array
const solutionArray = Array.isArray(props.exercise.solution)
    ? props.exercise.solution
    : [props.exercise.solution];

function selectAnswer(val) {
    answer.value = val;
    props.handleAnswer(solutionArray.includes(val), val);
}
</script>
<template>
    <div class="response-container">
        <div class="choice-options">
            <button
                class="option-button"
                :class="{
                    'green': props.showFeedback && answer.value === 'True' && solutionArray.includes('True'),
                    'red': props.showFeedback && answer.value === 'True' && !solutionArray.includes('True'),
                    'border-blue-600': answer.value === 'True'
                }"
                :disabled="props.showFeedback"
                @click="selectAnswer('True')"
            >
                Verdadero
            </button>
            <button
                class="option-button"
                :class="{
                    'green': props.showFeedback && answer.value === 'False' && solutionArray.includes('False'),
                    'red': props.showFeedback && answer.value === 'False' && !solutionArray.includes('False'),
                    'border-blue-600': answer.value === 'False'
                }"
                :disabled="props.showFeedback"
                @click="selectAnswer('False')"
            >
                Falso
            </button>
        </div>
        <div v-if="props.showFeedback" class="feedback-container">
            <button class="option-button" @click="props.nextExercise">Siguiente</button>
        </div>
    </div>
</template>
