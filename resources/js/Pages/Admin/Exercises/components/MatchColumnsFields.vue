<script setup>
import { watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
// Debug: mostrar en consola cada vez que cambian opciones o solución
watch(() => props.form.options, (val) => {
    console.log('Opciones:', JSON.stringify(val));
}, { deep: true });
watch(() => props.form.solution, (val) => {
    console.log('Solución:', JSON.stringify(val));
}, { deep: true });
function addOption() {
    props.form.options.push({ left: '', right: '' });
}
function removeOption(idx) {
    props.form.options.splice(idx, 1);
}
// Obtener valores únicos de la columna izquierda y derecha
function getLeftValues() {
    return [...new Set(props.form.options.map(opt => opt.left).filter(v => v))];
}
function getRightValues() {
    return [...new Set(props.form.options.map(opt => opt.right).filter(v => v))];
}
// Inicializar solución si no existe
if (!Array.isArray(props.form.solution)) {
    props.form.solution = [];
}
// Actualizar el match correcto para cada elemento de la izquierda
function setMatch(left, right) {
    const idx = props.form.solution.findIndex(p => p.left === left);
    if (idx !== -1) {
        props.form.solution[idx].right = right;
    } else {
        props.form.solution.push({ left, right });
    }
}
function getSelectedRight(left) {
    const pair = props.form.solution.find(p => p.left === left);
    return pair ? pair.right : '';
}
</script>
<template>
    <div>
        <!-- DEBUG VISUAL -->
        <label class="">Pares para relacionar</label>
        <div class="space-y-2">
            <div v-for="(option, idx) in props.form.options" :key="idx" class="">
                <input v-model="option.left" type="text" class="" placeholder="Columna izquierda" />
                <span class="left">→</span>
                <input v-model="option.right" type="text" class="" placeholder="Columna derecha" />
                <button type="button" @click="removeOption(idx)" class="bnt-excersice">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addOption" class="bnt-excersice">Agregar par</button>
        <span v-if="props.errors.options" class="">{{ props.errors.options }}</span>
        <div v-if="getLeftValues().length && getRightValues().length" class="">
            <label class="">Selecciona el match correcto para cada elemento de la izquierda:</label>
            <div class="">
                <div v-for="left in getLeftValues()" :key="'sol-' + left" class="">
                    <span class="left">{{ left }}</span>
                    <span class="left">→</span>
                    <select :value="getSelectedRight(left)" @change="setMatch(left, $event.target.value)" class="">
                        <option value="">Selecciona</option>
                        <option v-for="right in getRightValues()" :key="right" :value="right">{{ right }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="props.form.solution && props.form.solution.length" class="mt-4">
            <label class="">Solución guardada:</label>
            <ul class="">
                <li v-for="(pair, idx) in props.form.solution" :key="'saved-' + idx" class="left">
                    {{ pair.left }} → {{ pair.right }}
                </li>
            </ul>
        </div>
    </div>
</template>
