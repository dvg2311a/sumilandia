<template>
    <form @submit.prevent="submit" class="form-space">
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
                <label for="unit_id" class="label">Unidad</label>
                <select v-model="form.unit_id" id="unit_id" class="input" required>
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
