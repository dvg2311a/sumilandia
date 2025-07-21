<script setup>
import { ref, watch } from 'vue';
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: Array,
    handleAnswer: Function,
    nextExercise: Function
});

function getConceptos() {
  return Array.isArray(props.exercise.options)
    ? [...new Set(props.exercise.options.map(opt => opt.concepto).filter(v => v))]
    : [];
}
function getDefiniciones() {
  return Array.isArray(props.exercise.options)
    ? [...new Set(props.exercise.options.map(opt => opt.definicion).filter(v => v))]
    : [];
}
const conceptos = ref(getConceptos());
const definiciones = ref(getDefiniciones());
const selectedConcepto = ref(null);
const selectedDefinicion = ref(null);
const studentMatches = ref([]);
const feedback = ref({}); // {concepto: true/false}
const validated = ref(false); // Solo permitir un intento

watch(() => props.exercise, () => {
  conceptos.value = getConceptos();
  definiciones.value = getDefiniciones();
  selectedConcepto.value = null;
  selectedDefinicion.value = null;
  studentMatches.value = [];
  feedback.value = {};
  validated.value = false;
}, { immediate: true });

function validatePair(concepto, definicion) {
  const solutionArray = Array.isArray(props.exercise.solution)
    ? props.exercise.solution
    : [props.exercise.solution];
  return solutionArray.some(sol => sol.concepto === concepto && sol.definicion === definicion);
}

function selectConcepto(concepto) {
  selectedConcepto.value = concepto;
}
function selectDefinicion(definicion) {
  selectedDefinicion.value = definicion;
  if (selectedConcepto.value && selectedDefinicion.value) {
    const idx = studentMatches.value.findIndex(p => p.concepto === selectedConcepto.value);
    if (idx !== -1) {
      studentMatches.value[idx].definicion = selectedDefinicion.value;
    } else {
      studentMatches.value.push({ concepto: selectedConcepto.value, definicion: selectedDefinicion.value });
    }
    // Validar el par y guardar feedback inmediato
    feedback.value[selectedConcepto.value] = validatePair(selectedConcepto.value, selectedDefinicion.value);
    // Si alguna es incorrecta, validar automáticamente y bloquear
    if (feedback.value[selectedConcepto.value] === false && !validated.value) {
      validated.value = true;
      props.handleAnswer(false, JSON.parse(JSON.stringify(studentMatches.value)));
    }
    selectedConcepto.value = null;
    selectedDefinicion.value = null;
  }
}
function isMatched(concepto, definicion) {
  return studentMatches.value.some(p => p.concepto === concepto && p.definicion === definicion);
}
function isCorrectConcepto(concepto) {
  return feedback.value[concepto] === true;
}
function isIncorrectConcepto(concepto) {
  return feedback.value[concepto] === false;
}
function checkAnswer() {
    if (validated.value) return; // Solo permitir un intento
    const solutionArray = Array.isArray(props.exercise.solution)
        ? props.exercise.solution
        : [props.exercise.solution];
    const isCorrect = studentMatches.value.every(pair => {
        return solutionArray.some(sol => sol.concepto === pair.concepto && sol.definicion === pair.definicion);
    }) && studentMatches.value.length === solutionArray.length;
    validated.value = true;
    props.handleAnswer(isCorrect, JSON.parse(JSON.stringify(studentMatches.value)));
}
</script>
<template>
    <div class="mb-4">
        <div v-if="conceptos.length && definiciones.length" class="grid grid-cols-2 gap-4 mb-4">
            <!-- Columna conceptos -->
            <div>
                <div class="font-bold mb-2">Conceptos</div>
                <div class="grid gap-2">
                    <button
                        v-for="concepto in conceptos"
                        :key="concepto"
                        class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'bg-blue-200': selectedConcepto === concepto,
                            'bg-green-100': isCorrectConcepto(concepto),
                            'bg-red-100': isIncorrectConcepto(concepto),
                            'cursor-pointer': !props.showFeedback
                        }"
                        :disabled="props.showFeedback"
                        @click="selectConcepto(concepto)"
                    >
                        {{ concepto }}
                    </button>
                </div>
            </div>
            <!-- Columna definiciones -->
            <div>
                <div class="font-bold mb-2">Definiciones</div>
                <div class="grid gap-2">
                    <button
                        v-for="definicion in definiciones"
                        :key="definicion"
                        class="px-4 py-2 rounded border w-full shadow"
                        :class="{
                            'bg-blue-200': selectedDefinicion === definicion,
                            'bg-green-100': studentMatches.some(p => p.definicion === definicion),
                            'cursor-pointer': !props.showFeedback
                        }"
                        :disabled="props.showFeedback"
                        @click="selectDefinicion(definicion)"
                    >
                        {{ definicion }}
                    </button>
                </div>
            </div>
        </div>
        <div v-if="studentMatches.length" class="mb-2">
            <div class="font-bold text-xs mb-1">Pares seleccionados:</div>
            <ul class="text-xs">
                <li v-for="(pair, idx) in studentMatches" :key="idx">
                    {{ pair.concepto }} → {{ pair.definicion }}
                </li>
            </ul>
        </div>
        <button
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mt-2"
            @click="checkAnswer"
            :disabled="props.showFeedback || validated"
        >
            Comprobar respuesta
        </button>
        <div v-if="props.showFeedback || validated">
            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="props.nextExercise">Siguiente</button>
        </div>
    </div>
</template>
