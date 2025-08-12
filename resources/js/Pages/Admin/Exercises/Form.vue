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
    // Reset solution to an array so dialog-complete fields render correctly
    props.form.solution = [];
});
function addOption() {
    props.form.options.push('');
}
function removeOption(idx) {
    props.form.options.splice(idx, 1);
}
</script>
<template>
    <form @submit.prevent="props.onSubmit" class="formulario-exercises">
        <div class="container-items-exercises">
            <div class="items-form-exercises">
                <label class="label">Enunciado</label>
                <input v-model="props.form.prompt" type="text" class="input" />
                <span v-if="props.errors.prompt" class="error-text">{{ props.errors.prompt }}</span>
            </div>


            <div class="items-form-exercises">
                <label class="label">Lección</label>
                <select v-model="props.form.lesson_id" class="input">
                    <option value="">Selecciona una lección</option>
                    <option v-for="lesson in props.lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name }}
                    </option>
                </select>
                <span v-if="props.errors.lesson_id" class="error-text">{{ props.errors.lesson_id }}</span>
            </div>


            <div class="items-form-exercises">
                <label class="label">Explicación (opcional)</label>
                <input v-model="props.form.explanation" type="text" class="input" />
                <span v-if="props.errors.explanation" class="error-text">{{ props.errors.explanation }}</span>
            </div>

            <div class="items-form-exercises">
                <label class="label">Tipo de Ejercicio</label>
                <select v-model="props.form.exercise_type_id" class="input">
                    <option value="">Selecciona un tipo</option>
                    <option v-for="type in props.types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
                <span v-if="props.errors.exercise_type_id" class="error-text">{{ props.errors.exercise_type_id }}</span>
            </div>

            <div class="items-form-exercises">
                <component :is="selectedType.name === 'Opción múltiple' ? MultipleChoiceFields :
                selectedType.name === 'Verdadero o falso' ? TrueFalseFields :
                selectedType.name === 'Completar espacios' ? CompleteSpacesFields :
                (selectedType.name === 'Respuesta corta' || selectedType.name === 'Ensayo') ? ShortAnswerFields :
                selectedType.name === 'Relacionar columnas' ? MatchColumnsFields :
                selectedType.name === 'Ordenar elementos' ? OrderElementsFields :
                selectedType.name === 'Emparejar definiciones' ? MatchDefinitionsFields :
                selectedType.name === 'Completar diálogo' ? CompleteDialogFields : null" v-if="selectedType.name"
                :form="props.form" :errors="props.errors" />
            </div>
        </div>

        <div class="button-container">
            <button type="submit" class="">{{ props.isEdit ? 'Actualizar' : 'Guardar' }}</button>
        </div>
    </form>

</template>
<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
