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
    <label class="block text-sm font-medium text-gray-700 mb-2">Frases del diálogo</label>
    <div class="space-y-2">
      <div v-for="(item, idx) in props.form.options" :key="idx" class="flex gap-2 items-center">
        <input
          type="text"
          :value="item.frase"
          @input="e => updateFrase(idx, e.target.value)"
          class="border-gray-300 rounded-md shadow-sm w-96"
          placeholder="Escribe la frase y usa _ para el hueco"
        />
        <button type="button" @click="removePhrase(idx)" class="text-red-500 text-xs">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addPhrase" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar frase</button>
    <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">Solución (frases correctas para los huecos)</label>
      <div class="space-y-2">
        <div v-for="(sol, idx) in props.form.solution" :key="'sol-'+idx" class="flex gap-2 items-center">
          <input v-model="props.form.solution[idx]" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Palabra/frase para hueco" />
        </div>
      </div>
      <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
    </div>
  </div>
</template>
