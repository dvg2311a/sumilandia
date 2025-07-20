<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
function addOption() { props.form.options.push(''); }
function removeOption(idx) { props.form.options.splice(idx, 1); }
if (!Array.isArray(props.form.solution)) {
  props.form.solution = [];
}
watch(() => props.form.solution, (newVal) => {
  if (Array.isArray(newVal)) {
    props.form.solutionString = JSON.stringify(newVal);
  }
}, { deep: true });
</script>
<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Opciones</label>
    <div class="space-y-2">
      <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2">
        <input v-model="props.form.options[idx]" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" />
        <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar opción</button>
    <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700">Solución (selecciona una o varias)</label>
      <div class="space-y-2">
        <div v-for="(option, idx) in props.form.options" :key="'sol-'+idx" class="flex items-center gap-2">
          <input
            type="checkbox"
            :value="option"
            v-model="props.form.solution"
            class="form-checkbox"
          />
          <span>{{ option }}</span>
        </div>
      </div>
      <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
    </div>
  </div>
</template>
