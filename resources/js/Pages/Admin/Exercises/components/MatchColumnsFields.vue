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
      <div class="mb-2 p-2 bg-yellow-50 border border-yellow-300 rounded text-xs">
        <div><strong>DEBUG:</strong></div>
        <div>Opciones: {{ JSON.stringify(props.form.options) }}</div>
        <div>Solución: {{ JSON.stringify(props.form.solution) }}</div>
      </div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Pares para relacionar</label>
      <div class="space-y-2">
        <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2 items-center">
          <input v-model="option.left" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Columna izquierda" />
          <span class="mx-2">→</span>
          <input v-model="option.right" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Columna derecha" />
          <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
        </div>
      </div>
      <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar par</button>
      <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
      <div v-if="getLeftValues().length && getRightValues().length" class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona el match correcto para cada elemento de la izquierda:</label>
        <div class="space-y-2">
          <div v-for="left in getLeftValues()" :key="'sol-'+left" class="flex items-center gap-2">
            <span class="font-semibold">{{ left }}</span>
            <span class="mx-2">→</span>
            <select
              :value="getSelectedRight(left)"
              @change="setMatch(left, $event.target.value)"
              class="border-gray-300 rounded-md shadow-sm flex-1"
            >
              <option value="">Selecciona</option>
              <option v-for="right in getRightValues()" :key="right" :value="right">{{ right }}</option>
            </select>
          </div>
        </div>
      </div>
      <div v-if="props.form.solution && props.form.solution.length" class="mt-4">
        <label class="block text-xs text-gray-500 mb-1">Solución guardada:</label>
        <ul class="text-xs">
          <li v-for="(pair, idx) in props.form.solution" :key="'saved-'+idx">
            {{ pair.left }} → {{ pair.right }}
          </li>
        </ul>
      </div>
    </div>
</template>
