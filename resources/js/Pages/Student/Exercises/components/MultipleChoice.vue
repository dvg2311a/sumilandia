<script setup>
const props = defineProps({
    exercise: Object,
    showFeedback: Boolean,
    lastAnswer: [String, Number],
    handleAnswer: Function,
    nextExercise: Function
});
// Asegurarse que la solución sea array
const solutionArray = Array.isArray(props.exercise.solution)
    ? props.exercise.solution
    : [props.exercise.solution];
</script>
<template>
    <div class="mb-4">
        <template v-if="Array.isArray(props.exercise.options) && props.exercise.options.length">
            <div class="grid grid-cols-1 gap-2">
                <div v-for="option in props.exercise.options" :key="option">
                    <button
                        class="px-4 py-2 rounded border w-full shadow hover:bg-blue-100"
                        :class="{
                            'bg-green-100': props.showFeedback && solutionArray.includes(option),
                            'bg-red-100': props.showFeedback && props.lastAnswer === option && !solutionArray.includes(props.lastAnswer)
                        }"
                        :disabled="props.showFeedback"
                        @click="props.handleAnswer(solutionArray.includes(option), option)">
                        {{ option }}
                    </button>
                </div>
            </div>
            <div v-if="props.showFeedback">
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="props.nextExercise">Siguiente</button>
            </div>
        </template>
        <template v-else>
            <div class="text-red-600 font-bold">No hay opciones disponibles para este ejercicio.</div>
        </template>
    </div>
</template>
