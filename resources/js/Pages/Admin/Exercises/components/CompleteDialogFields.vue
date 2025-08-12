<script setup>
import { ref } from 'vue';
const props = defineProps({ form: Object, errors: Object });
if (!Array.isArray(props.form.options)) {
    props.form.options = [];
}
if (!Array.isArray(props.form.solution)) {
    props.form.solution = [];
}
function addPhrase() {
    props.form.options.push({ frase: '' });
    props.form.solution.push('');
}
function removePhrase(idx) {
    props.form.options.splice(idx, 1);
    props.form.solution.splice(idx, 1);
}
// Ya no se necesita updateSolutions, la sincronización es directa
function updateFrase(idx, val) {
    props.form.options[idx].frase = val;
}
function updateSolution(idx, val) {
    props.form.solution[idx] = val;
}
function addSolution() {
    props.form.solution.push('');
}
function removeSolution(idx) {
    props.form.solution.splice(idx, 1);
}
</script>
<template>
    <div>
        <label>Frases del diálogo</label>
        <div>
            <div v-for="(item, idx) in props.form.options" :key="idx">
                <input type="text" :value="item.frase" @input="e => updateFrase(idx, e.target.value)"
                    placeholder="Escribe la frase y usa _ para el hueco" />
                <button type="button" @click="removePhrase(idx)" class="bnt-excersice">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addPhrase" class="bnt-excersice">Agregar frase</button>
        <span v-if="props.errors.options">{{ props.errors.options }}</span>

        <div>
            <label>Solución (frases correctas para los huecos)</label>
            <div>
                <div v-for="(sol, idx) in props.form.solution" :key="'sol-' + idx">
                    <input v-model="props.form.solution[idx]" type="text" placeholder="Palabra/frase para hueco" />
                </div>
            </div>
            <span v-if="props.errors.solution">{{ props.errors.solution }}</span>
        </div>
    </div>

</template>
