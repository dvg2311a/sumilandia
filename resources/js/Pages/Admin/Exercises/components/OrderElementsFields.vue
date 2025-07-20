<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });
function addOption() { props.form.options.push(''); }
function removeOption(idx) { props.form.options.splice(idx, 1); }
if (!Array.isArray(props.form.solution)) {
  props.form.solution = [];
}
function setDefaultSolution() {
  if (props.form.solution.length === 0) {
    props.form.solution = props.form.options.slice();
  }
}
// Convierte la solución a string antes de enviar el formulario
watch(() => props.form.solution, (newVal) => {
  if (Array.isArray(newVal)) {
    props.form.solutionString = JSON.stringify(newVal);
  }
}, { deep: true });
// Drag and drop logic
const dragIndex = ref(null);
function onDragStart(idx) {
  dragIndex.value = idx;
}
function onDrop(idx) {
  if (dragIndex.value === null || dragIndex.value === idx) return;
  const moved = props.form.solution.splice(dragIndex.value, 1)[0];
  props.form.solution.splice(idx, 0, moved);
  dragIndex.value = null;
}
</script>
<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Elementos para ordenar</label>
    <div class="space-y-2">
      <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2">
        <input v-model="props.form.options[idx]" type="text" class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Elemento" />
        <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
      </div>
    </div>
    <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar elemento</button>
    <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700">Solución (orden correcto)</label>
      <button type="button" @click="setDefaultSolution" class="mb-2 bg-green-500 text-white px-2 py-1 rounded">Usar todos los elementos</button>
      <div v-if="props.form.solution.length" class="flex flex-col gap-2">
        <div
          v-for="(item, idx) in props.form.solution"
          :key="'sol-'+idx"
          class="flex items-center gap-2 bg-gray-100 rounded px-3 py-2 cursor-move shadow"
          draggable="true"
          @dragstart="onDragStart(idx)"
          @dragover.prevent
          @drop="onDrop(idx)"
        >
          <span class="flex-1">{{ item }}</span>
          <span class="text-xs text-gray-400">Arrastra para reordenar</span>
        </div>
      </div>
      <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
    </div>
  </div>
</template>
