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
        <label class="block text-sm font-medium text-gray-700 mb-2">Conceptos y definiciones</label>
        <div class="space-y-2">
            <div v-for="(pair, idx) in props.form.options" :key="idx" class="flex gap-2 items-center">
                <input v-model="pair.concepto" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Concepto" />
                <input v-model="pair.definicion" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Definición" />
                <button type="button" @click="removePair(idx)" class="text-red-500 text-xs">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addPair" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar
            par</button>
        <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Solución (elige la definición correcta para cada
                concepto)</label>
            <div class="space-y-2">
                <div v-for="concepto in getConceptos()" :key="'sol-' + concepto" class="flex gap-2 items-center">
                    <span class="font-semibold">{{ concepto }}</span>
                    <span class="mx-2">→</span>
                    <select :value="getSelectedDefinicion(concepto)" @change="setMatch(concepto, $event.target.value)"
                        class="flex-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">Selecciona definición</option>
                        <option v-for="definicion in getDefiniciones()" :key="definicion" :value="definicion">{{
                            definicion }}</option>
                    </select>
                </div>
            </div>
            <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
        </div>
    </div>
</template>
