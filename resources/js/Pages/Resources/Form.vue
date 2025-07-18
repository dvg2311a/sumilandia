<script setup>
import { useForm } from '@inertiajs/vue3';
import FileInput from '@/Components/FileInput.vue';

const props = defineProps({
    resource: Object,
    units: Array
});

const form = useForm({
    name: props.resource?.name || '',
    description: props.resource?.description || '',
    file_path: props.resource?.file_path || '',
    unit_id: props.resource?.unit_id || ''
});


function submit() {
    // Si el usuario no selecciona un nuevo archivo, mantener el valor anterior
    if (!form.file_path && props.resource?.file_path) {
        form.file_path = props.resource.file_path;
    }
    // Crear objeto limpio solo con campos con valor
    const data = {};
    if (form.name) data.name = String(form.name);
    if (form.description) data.description = String(form.description);
    if (form.unit_id) data.unit_id = String(form.unit_id);
    if (form.file_path !== null && form.file_path !== undefined && form.file_path !== '') {
        data.file_path = form.file_path;
    }
    // Debug: mostrar datos antes de enviar
    console.log('Datos enviados:', data);
    if (props.resource) {
        form.put(`/resources/${props.resource.id}`, {
            ...data,
            forceFormData: true,
            onSuccess: () => form.reset('file_path'),
        });
    } else {
        form.post('/resources', {
            ...data,
            forceFormData: true,
            onSuccess: () => form.reset('file_path'),
        });
    }
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input v-model="form.name" id="name" name="name" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
            <span v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</span>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea v-model="form.description" name="description" id="description" rows="3"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            <span v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</span>
        </div>
        <div>
            <label for="file_path" class="block text-sm font-medium text-gray-700">Archivo</label>
            <FileInput v-model="form.file_path" />
            <span v-if="form.errors.file_path" class="text-red-500 text-xs">{{ form.errors.file_path }}</span>
        </div>
        <div>
            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unidad</label>
            <select v-model="form.unit_id" id="unit_id" name="unit_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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
