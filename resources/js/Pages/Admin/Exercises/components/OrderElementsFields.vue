<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ form: Object, errors: Object });

// Estado para arrastrar y soltar
function addOption() { props.form.options.push(''); }
function removeOption(idx) { props.form.options.splice(idx, 1); }

if (!Array.isArray(props.form.solution)) {
    props.form.solution = [];
}
// Establecer solución por defecto si no hay
function setDefaultSolution() {
    if (props.form.solution.length === 0) {
        props.form.solution = props.form.options.slice();
    }
}
// Actualizar solución como cadena JSON para compatibilidad con dialog-complete
watch(() => props.form.solution, (newVal) => {
    if (Array.isArray(newVal)) {
        props.form.solutionString = JSON.stringify(newVal);
    }
}, { deep: true });

// Estado para arrastrar y soltar
const dragIndex = ref(null);

function onDragStart(idx) {
    dragIndex.value = idx;
}

// Permitir arrastrar y soltar para reordenar
function onDrop(idx) {
    if (dragIndex.value === null || dragIndex.value === idx) return;
    const moved = props.form.solution.splice(dragIndex.value, 1)[0];
    props.form.solution.splice(idx, 0, moved);
    dragIndex.value = null;
}
</script>

<template>
    <div>
        <label>Elementos para ordenar</label>
        <div>
            <div v-for="(option, idx) in props.form.options" :key="idx">
                <input v-model="props.form.options[idx]" type="text" placeholder="Elemento" />
                <button type="button" @click="removeOption(idx)" class="bnt-excersice">Eliminar</button>
            </div>
        </div>
        <button type="button" @click="addOption" class="bnt-excersice">Agregar elemento</button>
        <span v-if="props.errors.options">{{ props.errors.options }}</span>

        <div>
            <button type="button" @click="setDefaultSolution" class="bnt-excersice">Usar todos los elementos</button>
            <label>Solución (orden correcto)</label>
            <div v-if="props.form.solution.length">
                <div v-for="(item, idx) in props.form.solution" :key="'sol-' + idx" draggable="true"
                    @dragstart="onDragStart(idx)" @dragover.prevent @drop="onDrop(idx)" class="draggable-item">
                    <span class="item">{{ item }}</span>
                    <span class="left">(Arrastra para reordenar)</span>
                </div>
            </div>
            <span v-if="props.errors.solution">{{ props.errors.solution }}</span>
        </div>
    </div>
</template>
