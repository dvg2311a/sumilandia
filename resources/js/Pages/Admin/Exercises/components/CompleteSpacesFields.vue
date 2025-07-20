<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
if (!Array.isArray(props.form.solution)) {
  props.form.solution = [];
}
watch(() => props.form.solution, (newVal) => {
  if (Array.isArray(newVal)) {
    props.form.solutionString = JSON.stringify(newVal);
  }
}, { deep: true });
function addBlank() {
  props.form.solution.push('');
}
function removeBlank(idx) {
  props.form.solution.splice(idx, 1);
}
</script>
<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Soluciones (completa los espacios)</label>
    <div class="space-y-2">
      <div v-for="(blank, idx) in props.form.solution" :key="idx" class="flex gap-2">
        <input v-model="props.form.solution[idx]" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" />
        <button type="button" @click="removeBlank(idx)" class="text-red-500 text-xs">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addBlank" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar espacio</button>
    <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
  </div>
</template>
