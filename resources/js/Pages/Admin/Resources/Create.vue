<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from './Form.vue';

const props = defineProps({
    units: Array
});
</script>

<template>

    <Head title="Crear Recurso" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Recurso</h2>
            </div>
        </template>
        <div class="container-forms">
            <div class="title-forms">
                <div class="back">
                    <Link href="/resources">
                    <img src="/icons/return-icon.gif" alt="Regresar a la página anterior" class="btn-back" />
                    </Link>
                </div>
                <h1>Crear Recurso</h1>
            </div>
            <div class="form-container">
                <Form :units="units" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
