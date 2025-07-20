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
    <div class="mb-4">
        <div class="flex gap-4 mb-2">
            <button
                class="flex-1 px-4 py-6 rounded border shadow text-lg font-bold hover:bg-blue-100"
                :class="{
                    'bg-green-100': props.showFeedback && answer.value === 'True' && solutionArray.includes('True'),
                    'bg-red-100': props.showFeedback && answer.value === 'True' && !solutionArray.includes('True'),
                    'border-blue-600': answer.value === 'True'
                }"
                :disabled="props.showFeedback"
                @click="selectAnswer('True')"
            >
                Verdadero
            </button>
            <button
                class="flex-1 px-4 py-6 rounded border shadow text-lg font-bold hover:bg-blue-100"
                :class="{
                    'bg-green-100': props.showFeedback && answer.value === 'False' && solutionArray.includes('False'),
                    'bg-red-100': props.showFeedback && answer.value === 'False' && !solutionArray.includes('False'),
                    'border-blue-600': answer.value === 'False'
                }"
                :disabled="props.showFeedback"
                @click="selectAnswer('False')"
            >
                Falso
            </button>
        </div>
        <div v-if="props.showFeedback">
            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="props.nextExercise">Siguiente</button>
        </div>
    </div>
</template>
