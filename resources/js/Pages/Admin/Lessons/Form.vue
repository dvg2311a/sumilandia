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
        <div>
            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unidad</label>
            <select v-model="form.unit_id" id="unit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required>
                <option value="" disabled>Selecciona una unidad</option>
                <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
            </select>
            <span v-if="form.errors.unit_id" class="text-red-500 text-xs">{{ form.errors.unit_id }}</span>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    lesson: Object,
    units: Array
});

const form = useForm({
    name: props.lesson?.name || '',
    description: props.lesson?.description || '',
    unit_id: props.lesson?.unit_id || ''
});

function submit() {
    if (props.lesson) {
        form.put(`/lessons/${props.lesson.id}`);
    } else {
        form.post('/lessons');
    }
}
</script>
