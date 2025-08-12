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
    </div>

    <div class="button-container">
        <button type="submit" class="btn-primary">Guardar</button>
    </div>
</form>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    level: Object
});


const form = useForm({
    name: props.level?.name || '',
    description: props.level?.description || ''
});

function submit() {
    if (props.level) {
        form.put(`/levels/${props.level.id}`);
    } else {
        form.post('/levels');
    }
}
</script>
