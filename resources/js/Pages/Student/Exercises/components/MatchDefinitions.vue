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
    <div class="match-columns-container">
        <div v-if="conceptos.length && definiciones.length" class="items-container">
            <!-- Columna conceptos -->
            <div class="items-left items">
                <div class="title">
                    <h2>Conceptos</h2>
                </div>
                <div class="container-buttons">
                    <button v-for="concepto in conceptos" :key="concepto" class="" :class="{
                        'selected': selectedConcepto === concepto,
                        'green': isCorrectConcepto(concepto),
                        'red': isIncorrectConcepto(concepto),
                        'cursor-pointer': !props.showFeedback
                    }" :disabled="props.showFeedback" @click="selectConcepto(concepto)">
                        {{ concepto }}
                    </button>
                </div>
            </div>
            <!-- Columna definiciones -->
            <div class="items-right items">
                <div class="title">
                    <h2>Definiciones</h2>
                </div>
                <div class="container-buttons">
                    <button v-for="definicion in definiciones" :key="definicion" class="" :class="{
                        'selected': selectedDefinicion === definicion,
                        'green': studentMatches.some(p => p.definicion === definicion),
                        'cursor-pointer': !props.showFeedback
                    }" :disabled="props.showFeedback" @click="selectDefinicion(definicion)">
                        {{ definicion }}
                    </button>
                </div>
            </div>
        </div>

        <!--
            Mostrar pares seleccionados
            Solo si hay al menos un par seleccionado
            y no se ha validado la respuesta
        -->
        <div v-if="studentMatches.length" class="selected-pairs">
            <h3 class="">Pares seleccionados:</h3>
            <ul class="text-xs">
                <li v-for="(pair, idx) in studentMatches" :key="idx"
                    >
                    {{ pair.concepto }} → {{ pair.definicion }}
                </li>
            </ul>
        </div>

        <div class="container-button">
            <button class="" @click="checkAnswer" :disabled="props.showFeedback || validated">
                Comprobar respuesta
            </button>
            <div v-if="props.showFeedback || validated">
                <button class=""
                    @click="props.nextExercise">Siguiente</button>
            </div>
        </div>
    </div>
</template>
