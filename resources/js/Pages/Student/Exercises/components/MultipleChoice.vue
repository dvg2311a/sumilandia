<script setup>
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: [String, Number],
    handleAnswer: Function,
    nextExercise: Function
});
// Asegurarse que la solución sea array
//
import { computed } from 'vue';
const solutionArray = computed(() =>
    Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution]
);
</script>
<template>
    <div class="response-container">
        <template v-if="Array.isArray(props.exercise.options) && props.exercise.options.length">
            <div class="choice-options">
                <div v-for="option in props.exercise.options" :key="option">
                    <button
                        class="option-button"
                        :class="{
                            // Verde si es correcta y fue seleccionada, rojo si es incorrecta y fue seleccionada
                            'green': props.showFeedback && solutionArray.includes(lastAnswer) && props.lastAnswer === option,
                            'red': props.showFeedback && props.lastAnswer === option && !solutionArray.includes(props.lastAnswer)
                        }"
                        :disabled="props.showFeedback"
                        @click="props.handleAnswer(solutionArray.includes(option), option)">
                        {{ option }}
                    </button>
                </div>
            </div>
            <div v-if="props.showFeedback" class="feedback-container">
                <button class="option-button" @click="props.nextExercise">Siguiente</button>
            </div>
        </template>
        <template v-else>
            <div style="font-size: 1.5rem;">No hay opciones disponibles para este ejercicio.</div>
        </template>
    </div>
</template>
