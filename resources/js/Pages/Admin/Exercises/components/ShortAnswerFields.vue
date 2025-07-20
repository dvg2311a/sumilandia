<script setup>
const props = defineProps({ form: Object, errors: Object });
</script>
<template>
  <div>
    <label class="block text-sm font-medium text-gray-700">Solución</label>
    <input v-model="props.form.solution" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
    <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
  </div>
</template>
