<script setup>
import { ref } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: Array,
    handleAnswer: Function,
    nextExercise: Function
});
// Estado local para el orden del estudiante
const studentOrder = ref(Array.isArray(props.exercise.options) ? [...props.exercise.options] : []);
function moveUp(idx) {
    if (idx > 0) {
        const temp = studentOrder.value[idx - 1];
        studentOrder.value[idx - 1] = studentOrder.value[idx];
        studentOrder.value[idx] = temp;
    }
}
function moveDown(idx) {
    if (idx < studentOrder.value.length - 1) {
        const temp = studentOrder.value[idx + 1];
        studentOrder.value[idx + 1] = studentOrder.value[idx];
        studentOrder.value[idx] = temp;
    }
}
function checkAnswer() {
    // La solución puede ser array
    const solutionArray = Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution];
    const isCorrect = JSON.stringify(studentOrder.value) === JSON.stringify(solutionArray);
    props.handleAnswer(isCorrect, [...studentOrder.value]);
}
</script>
<template>
    <div class="order-elements">
        <div v-if="Array.isArray(studentOrder) && studentOrder.length" class="elements-list">
            <div v-for="(item, idx) in studentOrder" :key="item" class="items">
                <span>{{ item }}</span>
                <button @click="moveUp(idx)" :disabled="idx === 0 || props.showFeedback" class="button">↑</button>
                <button @click="moveDown(idx)" :disabled="idx === studentOrder.length - 1 || props.showFeedback"
                    class="">↓</button>
            </div>
        </div>

        <div class="button-response">
            <button class="" @click="checkAnswer" :disabled="props.showFeedback">
                Comprobar respuesta
            </button>
            <div v-if="props.showFeedback">
                <button class="" @click="props.nextExercise">Siguiente</button>
            </div>
        </div>
    </div>
</template>
