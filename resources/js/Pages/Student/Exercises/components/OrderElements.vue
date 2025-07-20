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
    <div class="mb-4">
        <div v-if="Array.isArray(studentOrder) && studentOrder.length">
            <div v-for="(item, idx) in studentOrder" :key="item" class="flex items-center gap-2 mb-2">
                <span class="flex-1 border rounded px-3 py-2">{{ item }}</span>
                <button @click="moveUp(idx)" :disabled="idx === 0 || props.showFeedback" class="px-2 py-1 bg-gray-200 rounded">↑</button>
                <button @click="moveDown(idx)" :disabled="idx === studentOrder.length - 1 || props.showFeedback" class="px-2 py-1 bg-gray-200 rounded">↓</button>
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
