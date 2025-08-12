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
        <label class="">Opciones</label>
        <div class="space-y-2">
            <div v-for="(option, idx) in props.form.options" :key="idx" class="">
                <input v-model="props.form.options[idx]" type="text" class="" />
                <button type="button" @click="removeOption(idx)" class="bnt-excersice">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addOption" class="bnt-excersice">Agregar opción</button>
        <span v-if="props.errors.options" class="">{{ props.errors.options }}</span>
        <div class="">
            <label class="">Solución (selecciona una o varias)</label>
            <div class="">
                <div v-for="(option, idx) in props.form.options" :key="'sol-' + idx" class="div-checkbox">
                    <input type="checkbox" :value="option" v-model="props.form.solution" class="form-checkbox" />
                    <span class="option">{{ option }}</span>
                </div>
            </div>
            <span v-if="props.errors.solution" class="">{{ props.errors.solution }}</span>
        </div>
    </div>
</template>
