<template>
    <form @submit.prevent="submit" class="form-space" enctype="multipart/form-data">
        <div class="container-items">
            <div class="items-form">
                <label for="name" class="label">Nombre</label>
                <input v-model="form.name" id="name" type="text" class="input" required />
                <span v-if="form.errors.name" class="error-text">{{ form.errors.name }}</span>
            </div>
            <div class="items-form">
                <label for="description" class="label">Descripción</label>
                <textarea v-model="form.description" id="description" rows="3" class="input"></textarea>
                <span v-if="form.errors.description" class="error-text">{{ form.errors.description }}</span>
            </div>
            <div class="items-form">
                <label for="expected_time" class="label">Tiempo esperado (minutos)</label>
                <input v-model="form.expected_time" id="expected_time" type="number" min="1" class="input" />
                <span v-if="form.errors.expected_time" class="error-text">{{ form.errors.expected_time }}</span>
            </div>

            <div class="items-form">
                <label for="image" class="label">Imagen</label>
                <input  id="image" class="input" required type="file" accept="image/*" @change="handleImageChange"/>
                <span v-if="form.errors.image" class="error-text">{{ form.errors.image }}</span>
            </div>

            <div class="items-form">
                <label for="level_id" class="label">Nivel</label>
                <select v-model="form.level_id" id="level_id" class="input" required>
                    <option value="" disabled>Selecciona un nivel</option>
                    <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
                </select>
                <span v-if="form.errors.level_id" class="error-text">{{ form.errors.level_id }}</span>
            </div>
        </div>
        <div class="button-container">
            <button type="submit" class="btn-primary">Guardar</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    unit: Object,
    levels: Array
});

const form = useForm({
    name: props.unit?.name || '',
    description: props.unit?.description || '',
    expected_time: props.unit?.expected_time || '',
    image: props.unit?.image || null,
    level_id: props.unit?.level_id || ''
}, {
    forceFormData: true
});

// Variable para trackear si se seleccionó nueva imagen
const hasNewImage = ref(false);

function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.image = file; // Asignar el archivo directamente
        hasNewImage.value = true;
    }
}

function submit() {
    if (props.unit) {
        // Para actualización
        form.transform((data) => {
            const formData = new FormData();

            // Agregar todos los campos
            formData.append('name', data.name);
            formData.append('description', data.description);
            formData.append('expected_time', data.expected_time);
            formData.append('level_id', data.level_id);

            // Solo agregar imagen si es un archivo nuevo
            if (data.image instanceof File) {
                formData.append('image', data.image);
            }

            // Para métodos PUT/PATCH en Laravel con FormData
            formData.append('_method', 'put');

            return formData;
        }).post(`/units/${props.unit.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Limpiar después de éxito si es necesario
            }
        });
    } else {
        // Para creación nueva
        form.post('/units', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            }
        });
    }
}
</script>
