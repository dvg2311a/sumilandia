<script setup>
import { ref, watch } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: Array,
    handleAnswer: Function,
    nextExercise: Function
});
// Estado local para los matches del estudiante
function getLeftValues() {
    return Array.isArray(props.exercise.options)
        ? [...new Set(props.exercise.options.map(opt => opt.left).filter(v => v))]
        : [];
}
function getRightValues() {
    return Array.isArray(props.exercise.options)
        ? [...new Set(props.exercise.options.map(opt => opt.right).filter(v => v))]
        : [];
}
const leftValues = ref(getLeftValues());
const rightValues = ref(getRightValues());
const selectedLeft = ref(null);
const selectedRight = ref(null);
const studentMatches = ref([]);
const checked = ref(false);

watch(() => props.exercise, () => {
    leftValues.value = getLeftValues();
    rightValues.value = getRightValues();
    selectedLeft.value = null;
    selectedRight.value = null;
    studentMatches.value = [];
    checked.value = false;
}, { immediate: true });

function selectLeft(left) {
    selectedLeft.value = left;
}
function selectRight(right) {
    selectedRight.value = right;
    // Si hay una selección de ambos lados, guardar el par y limpiar selección
    if (selectedLeft.value && selectedRight.value) {
        // Evitar duplicados
        const idx = studentMatches.value.findIndex(p => p.left === selectedLeft.value);
        if (idx !== -1) {
            studentMatches.value[idx].right = selectedRight.value;
        } else {
            studentMatches.value.push({ left: selectedLeft.value, right: selectedRight.value });
        }
        selectedLeft.value = null;
        selectedRight.value = null;
    }
}
function isMatched(left, right) {
    return studentMatches.value.some(p => p.left === left && p.right === right);
}
function checkAnswer() {
    const solutionArray = Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution];
    const isCorrect = studentMatches.value.every(pair => {
        return solutionArray.some(sol => sol.left === pair.left && sol.right === pair.right);
    }) && studentMatches.value.length === solutionArray.length;
    checked.value = true;
    props.handleAnswer(isCorrect, JSON.parse(JSON.stringify(studentMatches.value)));
}
function isPairCorrect(pair) {
    const solutionArray = Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution];
    return solutionArray.some(sol => sol.left === pair.left && sol.right === pair.right);
}
</script>
<template>
    <div class="match-columns-container">
        <div v-if="leftValues.length && rightValues.length" class="items-container">
            <!-- ?  Columna izquierda -->
            <div class="items-left items">
                <div class="title">
                    <h2>Izquierda</h2>
                </div>
                <div class="container-buttons">
                    <button v-for="left in leftValues" :key="left" class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'selected': selectedLeft === left,
                            'green': studentMatches.some(p => p.left === left),
                            'cursor-pointer': !props.showFeedback
                        }" :disabled="props.showFeedback" @click="selectLeft(left)">
                        {{ left }}
                    </button>
                </div>
            </div>

            <!-- ? Columna derecha -->
            <div class="items-right items">
                <div class="title">
                    <h2>Derecha</h2>
                </div>
                <div class="container-buttons">
                    <button v-for="right in rightValues" :key="right" class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'selected': selectedRight === right,
                            'green': studentMatches.some(p => p.right === right),
                            'cursor-pointer': !props.showFeedback
                        }" :disabled="props.showFeedback" @click="selectRight(right)">
                        {{ right }}
                    </button>
                </div>
            </div>
        </div>

        <!-- ?
            ? Esta sección muestra los pares seleccionados por el estudiante
            ? y resalta si son correctos o incorrectos al hacer clic en "Comprobar respuesta"
            ?Se muestra solo si hay pares seleccionados y el ejercicio ha sido respondido.
        ? -->

        <div v-if="studentMatches.length" class="selected-pairs">
            <h3 class="font-bold text-xs mb-1">Pares seleccionados:</h3>
            <ul class="text-xs">
                <li v-for="(pair, idx) in studentMatches" :key="idx"
                    :class="checked ? (isPairCorrect(pair) ? 'green' : 'red') : ''">
                    {{ pair.left }} → {{ pair.right }}
                </li>
            </ul>
        </div>

        <div class="container-button">
            <button class="2" @click="checkAnswer" :disabled="props.showFeedback || checked">
                Comprobar respuesta
            </button>
            <div v-if="props.showFeedback || checked">
                <button class=""
                    @click="props.nextExercise">Siguiente</button>
            </div>
        </div>
    </div>
</template>
