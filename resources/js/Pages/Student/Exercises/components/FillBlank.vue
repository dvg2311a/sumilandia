<script setup>
import { ref, computed, watch } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: String,
    handleAnswer: Function,
    nextExercise: Function
});
const answer = ref('');
const solutionArray = computed(() =>
    Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution]
);
// Reiniciar answer cuando cambie el ejercicio
watch(
    () => props.exercise,
    () => {
        answer.value = '';
    },
    { immediate: true }
);
</script>
<template>
    <div class="response-container">
        <div class="elements-container">
            <input v-model="answer" type="text" class=""
                :disabled="props.showFeedback" placeholder="Escribe tu respuesta aquí" />
            <button class="b" @click="props.handleAnswer(solutionArray.includes(answer), answer)"
                :disabled="answer === undefined || answer === '' || props.showFeedback">
                Comprobar respuesta
            </button>
            <div v-if="props.showFeedback" >
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    @click="props.nextExercise">Siguiente</button>
            </div>
        </div>
    </div>
</template>
