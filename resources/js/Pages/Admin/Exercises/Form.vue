<script setup>
import { ref, computed, watch } from 'vue';
import MultipleChoiceFields from './components/MultipleChoiceFields.vue';
import TrueFalseFields from './components/TrueFalseFields.vue';
import ShortAnswerFields from './components/ShortAnswerFields.vue';
import MatchColumnsFields from './components/MatchColumnsFields.vue';
import OrderElementsFields from './components/OrderElementsFields.vue';
import CompleteSpacesFields from './components/CompleteSpacesFields.vue';
import MatchDefinitionsFields from './components/MatchDefinitionsFields.vue';
import CompleteDialogFields from './components/CompleteDialogFields.vue';
const props = defineProps({
    form: Object,
    types: Array,
    lessons: Array,
    errors: Object,
    onSubmit: Function,
    isEdit: Boolean
});
const selectedType = computed(() => {
    return props.types.find(t => t.id === props.form.exercise_type_id) || {};
});
watch(() => props.form.exercise_type_id, () => {
    props.form.options = [];
    props.form.solution = '';
});
function addOption() {
    props.form.options.push('');
}
function removeOption(idx) {
    props.form.options.splice(idx, 1);
}
</script>
<template>
    <div class="w-full bg-white shadow-sm sm:rounded-lg p-6">
        <form @submit.prevent="props.onSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Enunciado</label>
                <input v-model="props.form.prompt" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="props.errors.prompt" class="text-red-500 text-xs">{{ props.errors.prompt }}</span>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Tipo de Ejercicio</label>
                <select v-model="props.form.exercise_type_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-800 bg-white">
                    <option value="">Selecciona un tipo</option>
                    <option v-for="type in props.types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
                <span v-if="props.errors.exercise_type_id" class="text-red-500 text-xs">{{ props.errors.exercise_type_id
                }}</span>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Lección</label>
                <select v-model="props.form.lesson_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-800 bg-white">
                    <option value="">Selecciona una lección</option>
                    <option v-for="lesson in props.lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name }}
                    </option>
                </select>
                <span v-if="props.errors.lesson_id" class="text-red-500 text-xs">{{ props.errors.lesson_id }}</span>
            </div>
            <!-- Campos dinámicos según tipo -->
            <div class="col-span-2">
                <component :is="selectedType.name === 'Opción múltiple' ? MultipleChoiceFields :
                    selectedType.name === 'Verdadero o falso' ? TrueFalseFields :
                        selectedType.name === 'Completar espacios' ? CompleteSpacesFields :
                            (selectedType.name === 'Respuesta corta' || selectedType.name === 'Ensayo') ? ShortAnswerFields :
                                selectedType.name === 'Relacionar columnas' ? MatchColumnsFields :
                                    selectedType.name === 'Ordenar elementos' ? OrderElementsFields :
                                        selectedType.name === 'Emparejar definiciones' ? MatchDefinitionsFields :
                                            selectedType.name === 'Completar diálogo' ? CompleteDialogFields : null
                    " v-if="selectedType.name" :form="props.form" :errors="props.errors" />
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Explicación (opcional)</label>
                <input v-model="props.form.explanation" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="props.errors.explanation" class="text-red-500 text-xs">{{ props.errors.explanation }}</span>
            </div>
            <div class="col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ props.isEdit
                    ? 'Actualizar' : 'Guardar' }}</button>
            </div>
        </form>
    </div>
</template>
<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
