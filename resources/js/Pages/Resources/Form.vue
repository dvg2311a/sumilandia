<script setup>
import { useForm } from '@inertiajs/vue3';
import FileInput from '@/Components/FileInput.vue';

const props = defineProps({
    resource: Object,
    units: Array
});

const form = useForm({
    _method: 'POST',
    name: props.resource?.name || '',
    description: props.resource?.description || '',
    file_path: null,
    unit_id: props.resource?.unit_id || ''
});


function submit() {
    if (props.resource) {
        form.transform(data => ({
            ...data,
            _method: 'PUT',
        })).post(`/resources/${props.resource.id}`, {
            onSuccess: () => form.reset('file_path'),
        });
    } else {
        form.post('/resources', {
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
            <div v-if="resource?.file_path" class="mt-2 text-xs text-gray-500">
                Archivo actual: <a :href="`/storage/${resource.file_path}`" target="_blank" class="text-indigo-600 hover:underline">{{ resource.file_path.split('/').pop() }}</a>
            </div>
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
