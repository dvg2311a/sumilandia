<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input v-model="form.name" id="name" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
            <span v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</span>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea v-model="form.description" id="description" rows="3"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            <span v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</span>
        </div>
        <div class="flex gap-6">
            <div class="w-1/2">
                <label for="expected_time" class="block text-sm font-medium text-gray-700">Tiempo esperado (minutos)</label>
                <input v-model="form.expected_time" id="expected_time" type="number" min="1"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <span v-if="form.errors.expected_time" class="text-red-500 text-xs">{{ form.errors.expected_time }}</span>
            </div>
            <div class="w-1/2">
                <label for="level_id" class="block text-sm font-medium text-gray-700">Nivel</label>
                <select v-model="form.level_id" id="level_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
                    <option value="" disabled>Selecciona un nivel</option>
                    <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
                </select>
                <span v-if="form.errors.level_id" class="text-red-500 text-xs">{{ form.errors.level_id }}</span>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object,
    levels: Array
});

const form = useForm({
    name: props.unit?.name || '',
    description: props.unit?.description || '',
    expected_time: props.unit?.expected_time || '',
    level_id: props.unit?.level_id || ''
});

function submit() {
    if (props.unit) {
        form.put(`/units/${props.unit.id}`);
    } else {
        form.post('/units');
    }
}
</script>
