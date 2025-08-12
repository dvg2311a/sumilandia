<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
// Obtener conceptos y definiciones únicos de las opciones
function getConceptos() {
    return [...new Set(props.form.options.map(opt => opt.concepto).filter(v => v))];
}
function getDefiniciones() {
    return [...new Set(props.form.options.map(opt => opt.definicion).filter(v => v))];
}
// Inicializar solución si no existe
if (!Array.isArray(props.form.solution)) {
    props.form.solution = [];
}
if (!Array.isArray(props.form.options)) {
    props.form.options = [];
}
// Setear la definición correcta para un concepto
function setMatch(concepto, definicion) {
    const idx = props.form.solution.findIndex(p => p.concepto === concepto);
    if (idx !== -1) {
        props.form.solution[idx].definicion = definicion;
    } else {
        props.form.solution.push({ concepto, definicion });
    }
}
function getSelectedDefinicion(concepto) {
    const pair = props.form.solution.find(p => p.concepto === concepto);
    return pair ? pair.definicion : '';
}
function addPair() {
    props.form.options.push({ concepto: '', definicion: '' });
}
function removePair(idx) {
    props.form.options.splice(idx, 1);
}
function addSolutionPair() {
    props.form.solution.push({ concepto: '', definicion: '' });
}
function removeSolutionPair(idx) {
    props.form.solution.splice(idx, 1);
}
</script>
<template>
    <div>
        <label>Conceptos y definiciones</label>
        <div>
            <div v-for="(pair, idx) in props.form.options" :key="idx">
                <input v-model="pair.concepto" type="text" placeholder="Concepto" />
                <input v-model="pair.definicion" type="text" placeholder="Definición" />
                <button type="button" @click="removePair(idx)" class="bnt-excersice">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addPair" class="bnt-excersice">Agregar par</button>
        <span v-if="props.errors.options">{{ props.errors.options }}</span>

        <div>
            <label>Solución (elige la definición correcta para cada concepto)</label>
            <div>
                <div v-for="concepto in getConceptos()" :key="'sol-' + concepto">
                    <span class="left">{{ concepto }}</span>
                    <span class="left">→</span>
                    <select :value="getSelectedDefinicion(concepto)" @change="setMatch(concepto, $event.target.value)">
                        <option value="">Selecciona definición</option>
                        <option v-for="definicion in getDefiniciones()" :key="definicion" :value="definicion">{{
                            definicion }}</option>
                    </select>
                </div>
            </div>
            <span v-if="props.errors.solution">{{ props.errors.solution }}</span>
        </div>
    </div>

</template>
