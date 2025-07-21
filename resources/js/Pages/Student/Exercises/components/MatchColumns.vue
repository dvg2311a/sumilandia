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
    <div class="mb-4">
        <div v-if="leftValues.length && rightValues.length" class="grid grid-cols-2 gap-4 mb-4">
            <!-- Columna izquierda -->
            <div>
                <div class="font-bold mb-2">Izquierda</div>
                <div class="grid gap-2">
                    <button
                        v-for="left in leftValues"
                        :key="left"
                        class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'bg-blue-200': selectedLeft === left,
                            'bg-green-100': studentMatches.some(p => p.left === left),
                            'cursor-pointer': !props.showFeedback
                        }"
                        :disabled="props.showFeedback"
                        @click="selectLeft(left)"
                    >
                        {{ left }}
                    </button>
                </div>
            </div>
            <!-- Columna derecha -->
            <div>
                <div class="font-bold mb-2">Derecha</div>
                <div class="grid gap-2">
                    <button
                        v-for="right in rightValues"
                        :key="right"
                        class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'bg-blue-200': selectedRight === right,
                            'bg-green-100': studentMatches.some(p => p.right === right),
                            'cursor-pointer': !props.showFeedback
                        }"
                        :disabled="props.showFeedback"
                        @click="selectRight(right)"
                    >
                        {{ right }}
                    </button>
                </div>
            </div>
        </div>
        <div v-if="studentMatches.length" class="mb-2">
            <div class="font-bold text-xs mb-1">Pares seleccionados:</div>
            <ul class="text-xs">
                <li v-for="(pair, idx) in studentMatches" :key="idx"
                    :class="checked ? (isPairCorrect(pair) ? 'text-green-600 font-bold' : 'text-red-600 font-bold') : ''">
                    {{ pair.left }} → {{ pair.right }}
                </li>
            </ul>
        </div>
        <button
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mt-2"
            @click="checkAnswer"
            :disabled="props.showFeedback || checked"
        >
            Comprobar respuesta
        </button>
        <div v-if="props.showFeedback || checked">
            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="props.nextExercise">Siguiente</button>
        </div>
    </div>
</template>
