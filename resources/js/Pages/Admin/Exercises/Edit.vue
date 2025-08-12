<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Form from './Form.vue';
const props = defineProps({
    exercise: Object,
    types: Array,
    lessons: Array,
    errors: Object
});
const form = ref({
    prompt: props.exercise.prompt,
    options: Array.isArray(props.exercise.options) ? [...props.exercise.options] : [],
    solution: props.exercise.solution,
    explanation: props.exercise.explanation,
    exercise_type_id: props.exercise.exercise_type_id,
    lesson_id: props.exercise.lesson_id
});
function submit() {
    router.put(`/exercises/${props.exercise.id}`, form.value);
}
</script>
<template>

    <Head title="Editar Ejercicio" />
    <AuthenticatedLayout>
        <template #header>
            <div class="">
                <h2 class="">Editar Ejercicio</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/exercises">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Editar Ejercicio</h1>
            </div>
            <div class="form-container">
                <Form :form="form" :types="types" :lessons="lessons" :errors="errors" :onSubmit="submit"
                    :isEdit="true" />
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
