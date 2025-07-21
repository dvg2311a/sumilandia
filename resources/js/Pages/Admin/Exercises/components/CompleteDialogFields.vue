<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
if (!Array.isArray(props.form.options)) {
  props.form.options = [];
}
if (!Array.isArray(props.form.solution)) {
  props.form.solution = [];
}
function addPhrase() {
  props.form.options.push({ frase: '', hueco: false });
}
function removePhrase(idx) {
  props.form.options.splice(idx, 1);
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
        <input v-model="item.frase" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Frase" />
        <input type="checkbox" v-model="item.hueco" class="ml-2" /> <span class="text-xs">¿Es hueco?</span>
        <button type="button" @click="removePhrase(idx)" class="text-red-500 text-xs">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addPhrase" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar frase</button>
    <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">Solución (frases correctas para los huecos)</label>
      <div class="space-y-2">
        <div v-for="(sol, idx) in props.form.solution" :key="'sol-'+idx" class="flex gap-2 items-center">
          <input v-model="props.form.solution[idx]" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Frase para hueco" />
          <button type="button" @click="removeSolution(idx)" class="text-red-500 text-xs">Eliminar</button>
        </div>
      </div>
      <button type="button" @click="addSolution" class="mt-2 bg-green-500 text-white px-2 py-1 rounded">Agregar solución</button>
      <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
    </div>
  </div>
</template>
