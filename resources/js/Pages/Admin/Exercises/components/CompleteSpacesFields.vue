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
    <label class="">Soluciones (completa los espacios)</label>
    <div class="">
      <div v-for="(blank, idx) in props.form.solution" :key="idx" class="">
        <input v-model="props.form.solution[idx]" type="text" class="" />
        <button type="button" @click="removeBlank(idx)" class="bnt-excersice">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addBlank" class="bnt-excersice">Agregar espacio</button>
    <span v-if="props.errors.solution" class="">{{ props.errors.solution }}</span>
  </div>
</template>
