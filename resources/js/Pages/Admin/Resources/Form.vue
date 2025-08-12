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
    file_path: '',
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
    <form @submit.prevent="submit" class="form-space">
        <div class="container-items">
            <div class="items-form">
                <label for="name" class="label">Nombre</label>
                <input v-model="form.name" id="name" name="name" type="text" class="input" required />
                <span v-if="form.errors.name" class="error-text">{{ form.errors.name }}</span>
            </div>

            <div class="items-form">
                <label for="description" class="label">Descripción</label>
                <textarea v-model="form.description" name="description" id="description" rows="3"
                    class="input"></textarea>
                <span v-if="form.errors.description" class="error-text">{{ form.errors.description }}</span>
            </div>

            <div class="items-form">
                <label for="file_path" class="label">Archivo</label>
                <FileInput v-model="form.file_path" />
                <div v-if="resource?.file_path" class="file-info">
                    <span>Archivo actual:</span>
                    <a :href="`/storage/${resource.file_path}`" target="_blank" class="name-file">
                        {{ resource.file_path.split('/').pop() }}
                    </a>
                </div>
                <span v-if="form.errors.file_path" class="error-text">{{ form.errors.file_path }}</span>
            </div>

            <div class="items-form">
                <label for="unit_id" class="label">Unidad</label>
                <select v-model="form.unit_id" id="unit_id" name="unit_id" class="input" required>
                    <option value="" disabled>Selecciona una unidad</option>
                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                </select>
                <span v-if="form.errors.unit_id" class="error-text">{{ form.errors.unit_id }}</span>
            </div>
        </div>

        <div class="button-container">
            <button type="submit" class="btn-primary">Guardar</button>
        </div>
    </form>

</template>
