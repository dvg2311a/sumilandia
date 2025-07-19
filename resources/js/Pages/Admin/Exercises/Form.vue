<script setup>
import { ref, computed, watch } from 'vue';
const props = defineProps({
    form: Object,
    types: Array,
    lessons: Array,
    errors: Object,
    onSubmit: Function,
    isEdit: Boolean
});
const selectedType = computed(() => {
    return props.types.find(t => t.id === props.form.exercise_type_id) || {};
});
watch(() => props.form.exercise_type_id, () => {
    props.form.options = [];
    props.form.solution = '';
});
function addOption() {
    props.form.options.push('');
}
function removeOption(idx) {
    props.form.options.splice(idx, 1);
}
</script>
<template>
    <div class="w-full bg-white shadow-sm sm:rounded-lg p-6">
        <form @submit.prevent="props.onSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Enunciado</label>
                <input v-model="props.form.prompt" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="props.errors.prompt" class="text-red-500 text-xs">{{ props.errors.prompt }}</span>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Tipo de Ejercicio</label>
                <select v-model="props.form.exercise_type_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-800 bg-white">
                    <option value="">Selecciona un tipo</option>
                    <option v-for="type in props.types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
                <span v-if="props.errors.exercise_type_id" class="text-red-500 text-xs">{{ props.errors.exercise_type_id
                    }}</span>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700">Lección</label>
                <select v-model="props.form.lesson_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-800 bg-white">
                    <option value="">Selecciona una lección</option>
                    <option v-for="lesson in props.lessons" :key="lesson.id" :value="lesson.id">{{ lesson.name }}
                    </option>
                </select>
                <span v-if="props.errors.lesson_id" class="text-red-500 text-xs">{{ props.errors.lesson_id }}</span>
            </div>
            <!-- Campos dinámicos según tipo -->
            <div v-if="selectedType.name === 'Opción múltiple'" class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opciones</label>
                <div class="space-y-2">
                    <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2">
                        <input v-model="props.form.options[idx]" type="text"
                            class="flex-1 border-gray-300 rounded-md shadow-sm" />
                        <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
                    </div>
                </div>
                <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar
                    opción</button>
                <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Solución</label>
                    <input v-model="props.form.solution" type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Escribe la solución" />
                    <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
                </div>
            </div>
            <div v-else-if="selectedType.name === 'Verdadero o falso'" class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Solución</label>
                <input v-model="props.form.solution" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Escribe la solución (Verdadero/Falso)" />
                <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
            </div>
            <div
                v-else-if="selectedType.name === 'Completar espacios' || selectedType.name === 'Respuesta corta' || selectedType.name === 'Ensayo'"
                class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Solución</label>
                <input v-model="props.form.solution" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
            </div>
            <div v-else-if="selectedType.name === 'Relacionar columnas'" class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pares para relacionar</label>
                <div class="space-y-2">
                    <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2">
                        <input v-model="props.form.options[idx]" type="text"
                            class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Par" />
                        <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
                    </div>
                </div>
                <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar
                    par</button>
                <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
            </div>
            <div v-else-if="selectedType.name === 'Ordenar elementos'" class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Elementos para ordenar</label>
                <div class="space-y-2">
                    <div v-for="(option, idx) in props.form.options" :key="idx" class="flex gap-2">
                        <input v-model="props.form.options[idx]" type="text"
                            class="flex-1 border-gray-300 rounded-md shadow-sm" placeholder="Elemento" />
                        <button type="button" @click="removeOption(idx)" class="text-red-500 text-xs">Eliminar</button>
                    </div>
                </div>
                <button type="button" @click="addOption" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded">Agregar
                    elemento</button>
                <span v-if="props.errors.options" class="text-red-500 text-xs">{{ props.errors.options }}</span>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Solución (orden correcto)</label>
                    <input v-model="props.form.solution" type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ej: 2,1,3" />
                    <span v-if="props.errors.solution" class="text-red-500 text-xs">{{ props.errors.solution }}</span>
                </div>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Explicación (opcional)</label>
                <input v-model="props.form.explanation" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="props.errors.explanation" class="text-red-500 text-xs">{{ props.errors.explanation }}</span>
            </div>
            <div class="col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ props.isEdit
                    ? 'Actualizar' : 'Guardar' }}</button>
            </div>
        </form>
    </div>
</template>
<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
