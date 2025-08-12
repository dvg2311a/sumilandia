<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Form from './Form.vue';
const props = defineProps({
    types: Array,
    lessons: Array,
    errors: Object
});
const form = ref({
    prompt: '',
    options: [],
    solution: '',
    explanation: '',
    exercise_type_id: '',
    lesson_id: ''
});
function submit() {
    router.post('/exercises', form.value);
}
</script>

<template>

    <Head title="Crear Ejercicio" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Ejercicio</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/exercises">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Crear Ejercicio</h1>
            </div>
            <div class="form-container">
                <Form :form="form" :types="types" :lessons="lessons" :errors="errors" :onSubmit="submit"
                    :isEdit="false" />
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
