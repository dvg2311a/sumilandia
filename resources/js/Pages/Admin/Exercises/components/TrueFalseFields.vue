<script setup>
import { watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
if (!Array.isArray(props.form.solution)) {
  props.form.solution = [];
}
// Mantener solo un valor en el array
watch(() => props.form.solution, (newVal) => {
  if (Array.isArray(newVal) && newVal.length > 1) {
    props.form.solution = [newVal[newVal.length - 1]];
  }
  props.form.solutionString = JSON.stringify(props.form.solution);
}, { deep: true });
</script>
<template>
  <div>
    <label class="block text-sm font-medium text-gray-700">Solución</label>
    <select v-model="props.form.solution[0]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      <option value="">Selecciona una opción</option>
      <option value="True">Verdadero</option>
      <option value="False">Falso</option>
    </select>
    <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
  </div>
</template>
